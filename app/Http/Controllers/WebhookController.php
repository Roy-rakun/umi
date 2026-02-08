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

        // 2. Validate Secret/Signature (Optional step, recommended)
        // For simplicity, we trust the payload ID matching our records
        
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

        $product = $order->product;
        $commissionAmount = ($affiliate->level === 'inner') 
            ? $product->commission_inner 
            : $product->commission_outer;

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
    }
}
