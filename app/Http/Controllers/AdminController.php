<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Order;
use App\Models\Commission;
use App\Models\Affiliate;
use App\Models\Payout;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Notifications\PayoutStatusNotification;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Core Stats
        $totalRevenue = Order::where('payment_status', 'paid')->sum('amount');
        $activeAffiliates = Affiliate::where('status', 'active')->count();
        $pendingPayouts = Payout::where('status', 'pending')->sum('total_amount');

        if ($pendingPayouts == 0) {
            $pendingPayouts = Commission::where('status', 'approved')->sum('commission_amount');
        }

        // 2. Growth Calculation (Simple Month-over-Month logic)
        $now = now();
        $thirtyDaysAgo = now()->subDays(30);
        $sixtyDaysAgo = now()->subDays(60);

        // Revenue Growth
        $currentMonthRev = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$thirtyDaysAgo, $now])
            ->sum('amount');
        $lastMonthRev = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])
            ->sum('amount');
        
        $revGrowth = ($lastMonthRev > 0) ? (($currentMonthRev - $lastMonthRev) / $lastMonthRev) * 100 : 0;

        // Commission Stats
        $approvedCommissions = Commission::where('status', 'approved')->sum('commission_amount');
        $currentMonthComm = Commission::where('status', 'approved')
            ->whereBetween('created_at', [$thirtyDaysAgo, $now])
            ->sum('commission_amount');
        $lastMonthComm = Commission::where('status', 'approved')
            ->whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])
            ->sum('commission_amount');
        
        $commGrowth = ($lastMonthComm > 0) ? (($currentMonthComm - $lastMonthComm) / $lastMonthComm) * 100 : 0;

        // Affiliate Growth (New affiliates in last 30 days)
        $newAffiliatesCount = Affiliate::whereBetween('created_at', [$thirtyDaysAgo, $now])->count();

        // 3. Top Affiliates
        $topAffiliates = Affiliate::with('user')
            ->orderByDesc('total_commission')
            ->take(5)
            ->get();

        // 4. Recent Orders
        $recentOrders = Order::with('product')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 
            'approvedCommissions', 
            'activeAffiliates', 
            'pendingPayouts',
            'topAffiliates',
            'recentOrders',
            'revGrowth',
            'commGrowth',
            'newAffiliatesCount'
        ));
    }

    public function affiliates()
    {
        $affiliates = Affiliate::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.affiliates', compact('affiliates'));
    }

    public function orders()
    {
        $orders = Order::with(['product', 'affiliate.user'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    // public function products() { return view('admin.products'); } // Replaced by ProductController

    public function commissions()
    {
        $commissions = Commission::with(['affiliate.user', 'product', 'order'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.commissions', compact('commissions'));
    }

    public function payouts()
    {
        $payouts = Payout::with('affiliate.user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.payouts', compact('payouts'));
    }

    public function settings()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function reports()
    {
        // 1. Total Revenue & Commissions
        $totalRevenue = Order::where('payment_status', 'paid')->sum('amount');
        $totalCommission = Commission::whereIn('status', ['approved', 'paid'])->sum('commission_amount');
        
        // 2. Monthly Revenue (Last 6 months)
        $monthlyRevenue = Order::select(
            DB::raw('sum(amount) as total'),
            DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month")
        )
        ->where('payment_status', 'paid')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        // 3. Top Products by Sales
        $topProducts = Order::select('product_id', DB::raw('count(*) as total_sold'))
            ->where('payment_status', 'paid')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.reports', compact('totalRevenue', 'totalCommission', 'monthlyRevenue', 'topProducts'));
    }

    public function fraudLogs()
    {
        $fraudLogs = \App\Models\FraudLog::with('affiliate.user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.fraud_logs', compact('fraudLogs'));
    }

    public function markNotificationsAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }

    public function approvePayout($payoutId)
    {
        $payout = Payout::with('affiliate.user')->findOrFail($payoutId);
        
        if ($payout->status !== 'pending') {
            return back()->with('error', 'Payout sudah diproses sebelumnya.');
        }
        
        $payout->update(['status' => 'approved']);
        
        // Send notification to affiliate
        $payout->affiliate->user->notify(new PayoutStatusNotification($payout, 'approved'));
        
        return back()->with('success', 'Payout berhasil disetujui dan notifikasi dikirim ke affiliate.');
    }

    public function rejectPayout(Request $request, $payoutId)
    {
        $payout = Payout::with('affiliate.user')->findOrFail($payoutId);
        
        if ($payout->status !== 'pending') {
            return back()->with('error', 'Payout sudah diproses sebelumnya.');
        }
        
        $payout->update([
            'status' => 'rejected',
            'notes' => $request->input('notes', 'Ditolak oleh admin')
        ]);
        
        // Return commissions back to approved status
        Commission::where('payout_id', $payout->payout_id)
            ->update(['status' => 'approved', 'payout_id' => null]);
        
        // Send notification to affiliate
        $payout->affiliate->user->notify(new PayoutStatusNotification($payout, 'rejected'));
        
        return back()->with('success', 'Payout ditolak dan notifikasi dikirim ke affiliate.');
    }

    public function completePayout($payoutId)
    {
        $payout = Payout::with('affiliate.user')->findOrFail($payoutId);
        
        if ($payout->status !== 'approved') {
            return back()->with('error', 'Payout harus dalam status approved untuk bisa diselesaikan.');
        }
        
        $payout->update([
            'status' => 'completed',
            'payment_date' => now()
        ]);
        
        // Send notification to affiliate
        $payout->affiliate->user->notify(new PayoutStatusNotification($payout, 'completed'));
        
        return back()->with('success', 'Payout berhasil diselesaikan dan notifikasi dikirim ke affiliate.');
    }
}

