<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Order;
use App\Models\Affiliate;
use App\Models\AffiliateLink;
use App\Models\Commission;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewAffiliateNotification; // Added this line
use Illuminate\Support\Facades\Notification;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Affiliate Tracking Logic
        if ($request->has('ref')) {
            $refCode = $request->query('ref');
            
            // Verifikasi validitas affiliate code (optional, tapi bagus untuk performa)
            $affiliate = Affiliate::where('referral_code', $refCode)->first();
            
            if ($affiliate) {
                // Simpan cookie selama 30 hari (43200 menit)
                Cookie::queue('affiliate_ref', $refCode, 43200);
                
                // Catat klik (optional complexity: unique click check)
                // Disini kita asumsi simple click tracking
                // Cari atau buat tracking link record
                
                // Logic simple: update clicks di affiliate_links table, 
                // tapi kita butuh product_id spesifik biasanya. 
                // Untuk general home link, kita bisa buat dummy product_id atau null.
                // Disini kita skip pencatatan klik detail untuk simplifikasi, fokus ke cookie.
            }
        }

        $products = Product::take(4)->get();
        return view('landing', compact('products'));
    }

    public function products()
    {
        $products = Product::all();
        return view('landing.products', compact('products'));
    }

    public function showPage($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
        return view('landing.page', compact('page'));
    }

    public function checkout(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // Simulasi data pembeli (Hardcoded for demo)
        $buyerName = 'Guest Buyer ' . Str::random(4);
        $buyerEmail = strtolower(Str::random(5)) . '@gmail.com';
        
        // Ambil affiliate ref dari cookie
        $affiliateRef = Cookie::get('affiliate_ref');
        $affiliateId = null;

        if ($affiliateRef) {
            $affiliate = Affiliate::where('referral_code', $affiliateRef)->first();
            if ($affiliate) {
                $affiliateId = $affiliate->affiliate_id;
            }
        }

        // Create Order
        $order = Order::create([
            'order_id' => 'ORD-' . strtoupper(Str::random(8)),
            'product_id' => $product->product_id,
            'affiliate_ref' => $affiliateRef, // Code yang dipakai
            'affiliate_id' => $affiliateId,   // ID asli affiliate
            'buyer_name' => $buyerName,
            'buyer_email' => $buyerEmail,
            'amount' => $product->price,
            'payment_status' => 'paid', // Auto paid for demo
            'ip_address' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewOrderNotification($order));

        // Calculate Commission if affiliate exists
        if ($affiliateId) {
            $affiliateUser = $affiliate->user; // Relation defined in Affiliate model
            
            // 1. SELF-ORDER FRAUD CHECK
            // Check if buyer email matches affiliate email
            if ($buyerEmail === $affiliateUser->email) {
                // Log Fraud
                \App\Models\FraudLog::create([
                    'affiliate_id' => $affiliateId,
                    'order_id' => $order->order_id,
                    'fraud_type' => 'self_order',
                    'evidence_data' => json_encode(['buyer_email' => $buyerEmail, 'affiliate_email' => $affiliateUser->email]),
                    'action_taken' => 'commission_rejected'
                ]);

                // Create Rejected Commission Record
                Commission::create([
                    'commission_id' => 'COM-' . strtoupper(Str::random(8)),
                    'order_id' => $order->order_id,
                    'affiliate_id' => $affiliateId,
                    'product_id' => $product->product_id,
                    'commission_amount' => 0,
                    'status' => 'rejected',
                    'rejection_reason' => 'Self-order detected',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            
            } else {
                // 2. VALID COMMISSION LOGIC
                // Commission will be created via Webhook when status is PAID
                // But we can check if it's inner/outer here just for validation if needed
                
                // $commissionAmount = ($affiliate->level === 'inner') 
                //    ? $product->commission_inner 
                //    : $product->commission_outer;
    
                // Commission::create([...]); -> MOVED TO WEBHOOK
                
                // Update total commission stats in Affiliate table -> MOVED TO WEBHOOK
            }
        }

        // --- PAYMENT INTEGRATION ---
        
        try {
            $mayarService = new \App\Services\MayarService();
            $paymentData = $mayarService->createPaymentLink($order, $buyerName, $buyerEmail);
            
            if ($paymentData && isset($paymentData['link'])) {
                $order->update([
                    'payment_link' => $paymentData['link'],
                    'external_id' => $paymentData['id'] ?? null,
                ]);
                
                return redirect($paymentData['link']);
            }
        } catch (\Exception $e) {
            // Log error or fallback
            \Illuminate\Support\Facades\Log::error('Mayar Payment Error: ' . $e->getMessage());
        }

        // Fallback or Demo Mode (If no API key or error)
        return redirect('/')->with('success', "Order placed successfully! Order ID: {$order->order_id}. Please complete your payment.");
    }
}
