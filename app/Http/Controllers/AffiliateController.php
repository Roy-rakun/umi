<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use App\Models\Affiliate;
use App\Models\Commission;
use App\Models\AffiliateLink;
use App\Models\Payout;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NewPayoutRequestNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan user punya data affiliate
        $affiliate = Affiliate::where('user_id', $user->id)->first();

        if (!$affiliate) {
            return redirect()->route('home')->with('error', 'Affiliate account not found.');
        }

        // 1. Stats
        $totalEarnings = $affiliate->total_commission;
        $totalClicks = AffiliateLink::where('affiliate_id', $affiliate->affiliate_id)->sum('clicks');
        $successfulOrders = Commission::where('affiliate_id', $affiliate->affiliate_id)
            ->whereIn('status', ['paid', 'approved'])
            ->count();
        
        // Available Balance = Total Commission - Total Payout
        // Atau hitung dari commission status 'approved'
        $availableBalance = Commission::where('affiliate_id', $affiliate->affiliate_id)
            ->where('status', 'approved')
            ->sum('commission_amount');

        // 2. Recent Commissions
        $recentCommissions = Commission::with(['order.product'])
            ->where('affiliate_id', $affiliate->affiliate_id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // 3. Link (Ambil link pertama atau generate default)
        $referralLink = url('/ref/' . $affiliate->referral_code);

        // 4. Products for Link Generator
        $products = \App\Models\Product::all(['product_id', 'name']);

        return view('affiliate.dashboard', compact(
            'user',
            'affiliate',
            'totalEarnings',
            'totalClicks',
            'successfulOrders',
            'availableBalance',
            'recentCommissions',
            'referralLink',
            'products'
        ));
    }

    public function myLinks()
    {
        $affiliate = Affiliate::where('user_id', auth()->id())->firstOrFail();
        $referralLink = url('/ref/' . $affiliate->referral_code);
        $products = \App\Models\Product::all(['product_id', 'name']);
        
        return view('affiliate.my_links', compact('referralLink', 'products'));
    }

    public function performance()
    {
        return view('affiliate.performance');
    }

    public function commissions()
    {
        $user = Auth::user();
        $affiliate = Affiliate::where('user_id', $user->id)->firstOrFail();
        
        $commissions = Commission::with(['order.product'])
            ->where('affiliate_id', $affiliate->affiliate_id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('affiliate.commissions', compact('commissions', 'affiliate'));
    }

    public function payouts()
    {
        $user = Auth::user();
        $affiliate = Affiliate::where('user_id', $user->id)->firstOrFail();
        
        $payouts = Payout::where('affiliate_id', $affiliate->affiliate_id)
            ->orderByDesc('created_at')
            ->paginate(10);
            
        $availableBalance = Commission::where('affiliate_id', $affiliate->affiliate_id)
            ->where('status', 'approved')
            ->sum('commission_amount');

        return view('affiliate.payouts', compact('payouts', 'affiliate', 'availableBalance'));
    }

    public function marketingAssets()
    {
        $products = \App\Models\Product::paginate(12);
        return view('affiliate.marketing_assets', compact('products'));
    }

    public function academy()
    {
        $pages = \App\Models\Page::where('is_academy', true)->orderByDesc('updated_at')->get();
        return view('affiliate.academy', compact('pages'));
    }

    public function requestPayout(Request $request)
    {
        $user = Auth::user();
        $affiliate = Affiliate::where('user_id', $user->id)->firstOrFail();

        // Calculate available balance
        $availableBalance = Commission::where('affiliate_id', $affiliate->affiliate_id)
            ->where('status', 'approved')
            ->sum('commission_amount');

        if ($availableBalance < 100000) {
            return back()->with('error', 'Minimum withdrawal is Rp 100.000');
        }

        // Create Payout Request
        $payout = Payout::create([
            'payout_id' => 'PAY-' . strtoupper(Str::random(8)),
            'affiliate_id' => $affiliate->affiliate_id,
            'total_amount' => $availableBalance,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update commissions status to 'payout_pending' or similar if needed 
        // to prevent double withdrawal, but usually we just track via Payout model.
        // For simplicity, let's just mark these commissions as processed/payout_pending
        Commission::where('affiliate_id', $affiliate->affiliate_id)
            ->where('status', 'approved')
            ->update(['status' => 'payout_pending', 'payout_id' => $payout->payout_id]);

        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewPayoutRequestNotification($payout->load('affiliate.user')));

        return back()->with('success', 'Payout request submitted successfully!');
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('affiliate.notifications', compact('notifications'));
    }

    public function markAllNotificationsAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * Display orders for the logged-in buyer/affiliate
     */
    public function orders()
    {
        $user = Auth::user();
        
        // Get orders by buyer email
        $orders = Order::with(['items.product'])
            ->where('buyer_email', $user->email)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('affiliate.orders', compact('orders'));
    }

    /**
     * Get order detail for modal
     */
    public function orderDetail($orderId)
    {
        $order = Order::with(['items.product'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        // Check if user owns this order
        if ($order->buyer_email !== auth()->user()->email) {
            abort(403, 'Unauthorized access to this order.');
        }

        return response()->json([
            'success' => true,
            'order' => $order,
            'shipping_details' => json_decode($order->shipping_details, true),
        ]);
    }

    /**
     * Retry payment - generate new payment link
     */
    public function retryPayment($orderId)
    {
        $order = Order::where('order_id', $orderId)->firstOrFail();

        // Check if user owns this order
        if ($order->buyer_email !== auth()->user()->email) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this order.'
            ], 403);
        }

        // If payment link exists, return it
        if ($order->payment_link) {
            return response()->json([
                'success' => true,
                'payment_link' => $order->payment_link
            ]);
        }

        // Try to create new payment link
        try {
            $mayarService = new \App\Services\MayarService();
            $paymentData = $mayarService->createPaymentLink($order, $order->buyer_name, $order->buyer_email);

            if ($paymentData && isset($paymentData['link'])) {
                $order->update([
                    'payment_link' => $paymentData['link'],
                    'external_id' => $paymentData['id'] ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'payment_link' => $paymentData['link']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat link pembayaran. Response tidak valid.'
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Retry Payment Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat link pembayaran: ' . $e->getMessage()
            ]);
        }
    }
}
