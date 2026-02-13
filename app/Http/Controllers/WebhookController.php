<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Commission;
use App\Models\Affiliate;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewCommissionNotification;

class WebhookController extends Controller
{
    public function handleMayar(Request $request)
    {
        // 1. Log incoming webhook for debugging
        Log::info('Mayar Webhook Received:', $request->all());

        // 2. Validate Secret/Signature (Recommended for security)
        $settings = Setting::all()->pluck('value', 'key');
        $webhookSecret = $settings['mayar_webhook_secret'] ?? null;
        
        if ($webhookSecret) {
            $signature = $request->header('X-Mayar-Signature') 
                ?? $request->header('Mayar-Signature')
                ?? $request->header('Signature');
            
            if (!$signature) {
                Log::warning('Mayar Webhook: Missing signature');
                // For development, we allow without signature if secret is not configured
                // In production, you should uncomment the line below:
                // return response()->json(['message' => 'Missing signature'], 401);
            } else {
                $payload = $request->getContent();
                $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
                
                if (!hash_equals($expectedSignature, $signature)) {
                    Log::warning('Mayar Webhook: Invalid signature', [
                        'expected' => $expectedSignature,
                        'received' => $signature
                    ]);
                    return response()->json(['message' => 'Invalid signature'], 401);
                }
            }
        }
        
        $transactionStatus = $request->input('status'); // paid, failed, etc.
        $externalId = $request->input('external_id'); // Our Order ID
        
        if (!$externalId) {
            return response()->json(['message' => 'No External ID provided'], 400);
        }

        $order = Order::where('order_id', $externalId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 3. Process Payment
        if ($transactionStatus === 'paid' && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'updated_at' => now(),
            ]);

            // 4. Calculate Commission (Moved from LandingController)
            $this->processCommission($order);
        }

        return response()->json(['status' => 'success']);
    }

    protected function processCommission($order)
    {
        if (!$order->affiliate_id) {
            return;
        }

        $affiliate = Affiliate::find($order->affiliate_id);
        if (!$affiliate) {
            return;
        }

        // Check for existing commission to avoid duplicates
        $existingCommission = Commission::where('order_id', $order->order_id)->first();
        if ($existingCommission) {
            return; // Already processed
        }

        // Support multi-item orders - calculate commission from all order items
        $orderItems = $order->items()->with('product')->get();
        
        if ($orderItems->isEmpty()) {
            // Fallback to legacy single product order
            $product = $order->product;
            if (!$product) {
                return;
            }
            
            $commissionAmount = ($affiliate->level === 'inner') 
                ? ($product->commission_inner ?? 0)
                : ($product->commission_outer ?? 0);

            if ($commissionAmount <= 0) {
                return;
            }

            $commission = Commission::create([
                'commission_id' => 'COM-' . strtoupper(Str::random(8)),
                'order_id' => $order->order_id,
                'affiliate_id' => $affiliate->affiliate_id,
                'product_id' => $product->product_id,
                'commission_amount' => $commissionAmount,
                'status' => 'approved', // Auto-approve if paid
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $affiliate->increment('total_commission', $commissionAmount);
            
            // Send notification to affiliate
            $affiliate->user->notify(new NewCommissionNotification($commission));
        } else {
            // Process commission for each order item
            $totalCommission = 0;
            $commissions = [];
            
            foreach ($orderItems as $item) {
                $product = $item->product;
                if (!$product) {
                    continue;
                }
                
                $itemCommission = ($affiliate->level === 'inner') 
                    ? ($product->commission_inner ?? 0)
                    : ($product->commission_outer ?? 0);
                
                // Multiply by quantity
                $itemCommission = $itemCommission * $item->quantity;
                
                if ($itemCommission > 0) {
                    $commission = Commission::create([
                        'commission_id' => 'COM-' . strtoupper(Str::random(8)),
                        'order_id' => $order->order_id,
                        'affiliate_id' => $affiliate->affiliate_id,
                        'product_id' => $product->product_id,
                        'commission_amount' => $itemCommission,
                        'status' => 'approved',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    $commissions[] = $commission;
                    $totalCommission += $itemCommission;
                }
            }
            
            if ($totalCommission > 0) {
                $affiliate->increment('total_commission', $totalCommission);
                
                // Send notification for the first commission (or you can send summary)
                if (!empty($commissions)) {
                    $affiliate->user->notify(new NewCommissionNotification($commissions[0]));
                }
            }
        }
    }
}
