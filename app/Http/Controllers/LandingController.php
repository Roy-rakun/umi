<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
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

        $products = Product::orderBy('sort_order', 'asc')->take(4)->get();
        $sections = \App\Models\LandingSection::orderBy('sort_order', 'asc')->get()->keyBy('key');
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        return view('landing.online_viewer', compact('products', 'sections', 'settings'));
    }

    /**
     * Handle short referral link format: /ref/{code}
     */
    public function handleReferralLink(Request $request, $code)
    {
        // Verify affiliate code
        $affiliate = Affiliate::where('referral_code', $code)->first();
        
        if ($affiliate) {
            // Save cookie for 30 days
            Cookie::queue('affiliate_ref', $code, 43200);
        }
        
        // Redirect to home with the ref parameter for additional tracking
        return redirect()->route('home', ['ref' => $code]);
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
        $allProducts = Product::where('product_id', '!=', $productId)->get();
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        return view('landing.checkout', compact('product', 'allProducts', 'settings'));
    }

    public function processCheckout(Request $request)
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        // 1. Check Login Requirement
        if (isset($settings['require_login_checkout']) && $settings['require_login_checkout'] == '1') {
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.',
                    'redirect' => route('login')
                ], 401);
            }
        }

        $cart = $request->input('cart');
        $buyer = $request->input('buyer');

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.'], 400);
        }

        $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
        
        // 2. Affiliate Tracking
        $affiliateRef = Cookie::get('affiliate_ref');
        $affiliateId = null;

        if ($affiliateRef) {
            $affiliate = Affiliate::where('referral_code', $affiliateRef)->first();
            if ($affiliate) {
                $affiliateId = $affiliate->affiliate_id;
            }
        }

        // 3. Create Order
        $order = Order::create([
            'order_id' => 'ORD-' . strtoupper(Str::random(8)),
            'product_id' => $cart[0]['product_id'], // Legacy support / Fallback
            'affiliate_ref' => $affiliateRef, 
            'affiliate_id' => $affiliateId,   
            'buyer_name' => $buyer['name'],
            'buyer_email' => $buyer['email'],
            'buyer_phone' => $buyer['phone'] ?? null,
            'amount' => $totalAmount,
            'payment_status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        // 4. Create Order Items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['qty'],
            ]);
        }

        // 5. Payment Integration (Mayar)
        try {
            $mayarService = new \App\Services\MayarService();
            $paymentData = $mayarService->createPaymentLink($order, $buyer['name'], $buyer['email']);
            
            if ($paymentData && isset($paymentData['link'])) {
                $order->update([
                    'payment_link' => $paymentData['link'],
                    'external_id' => $paymentData['id'] ?? null,
                ]);
                
                // Notify Admin
                $admins = User::where('role', 'admin')->get();
                Notification::send($admins, new NewOrderNotification($order));
                
                return response()->json([
                    'success' => true,
                    'payment_link' => $paymentData['link']
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mayar Payment Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal membuat link pembayaran: ' . $e->getMessage()], 500);
        }

        return response()->json(['success' => false, 'message' => 'Gagal memproses pembayaran.'], 500);
    }
}
