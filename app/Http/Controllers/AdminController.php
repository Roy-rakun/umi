<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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

    public function verifyAffiliate($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $user = $affiliate->user;

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $affiliate->update(['status' => 'active']);
            return back()->with('success', "Akun {$user->name} berhasil diverifikasi secara manual.");
        }

        return back()->with('info', "Akun {$user->name} sudah terverifikasi sebelumnya.");
    }

    public function verifyAllAffiliates()
    {
        $unverifiedAffiliates = Affiliate::whereHas('user', function ($query) {
            $query->whereNull('email_verified_at');
        })->get();

        $count = 0;
        foreach ($unverifiedAffiliates as $affiliate) {
            $affiliate->user->markEmailAsVerified();
            $affiliate->update(['status' => 'active']);
            $count++;
        }

        return back()->with('success', "Total $count akun berhasil diverifikasi secara massal.");
    }

    public function suspendAffiliate($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $affiliate->update(['status' => 'suspended']);
        
        return back()->with('success', "Affiliate {$affiliate->user->name} berhasil ditangguhkan.");
    }

    public function unsuspendAffiliate($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $affiliate->update(['status' => 'active']);
        
        return back()->with('success', "Affiliate {$affiliate->user->name} berhasil diaktifkan kembali.");
    }

    public function deleteAffiliate($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $user = $affiliate->user;
        $name = $user->name;
        
        // Delete related data
        $affiliate->commissions()->delete();
        $affiliate->payouts()->delete();
        $affiliate->links()->delete();
        
        // Delete affiliate record
        $affiliate->delete();
        
        // Delete user
        $user->delete();
        
        return back()->with('success', "Affiliate $name berhasil dihapus secara permanen.");
    }

    public function storeAffiliate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'affiliate',
                'phone' => $request->phone,
                'email_verified_at' => now(), // Auto verify
                'status' => 'active',
            ]);

            $affiliate = Affiliate::create([
                'user_id' => $user->id,
                'affiliate_id' => 'AFF-' . strtoupper(Str::random(8)),
                'status' => 'active',
                'level' => $request->level ?? 'outer',
            ]);

            $user->update(['affiliate_id' => $affiliate->affiliate_id]);

            DB::commit();
            return back()->with('success', "Affiliate {$user->name} berhasil didaftarkan.");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mendaftarkan affiliate: ' . $e->getMessage());
        }
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->payment_status == 'cancelled') {
            return back()->with('error', 'Pesanan sudah dibatalkan sebelumnya.');
        }
        
        if ($order->payment_status == 'paid') {
            return back()->with('error', 'Tidak dapat membatalkan pesanan yang sudah dibayar.');
        }
        
        $order->update(['payment_status' => 'cancelled']);
        
        // Cancel related commissions
        Commission::where('order_id', $order->order_id)->update(['status' => 'cancelled']);
        
        return back()->with('success', "Pesanan #{$order->order_id} berhasil dibatalkan.");
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $orderId = $order->order_id;
        
        // Delete related commissions first
        Commission::where('order_id', $order->order_id)->delete();
        
        // Delete order items if exists
        \App\Models\OrderItem::where('order_id', $order->order_id)->delete();
        
        // Delete the order
        $order->delete();
        
        return back()->with('success', "Pesanan #{$orderId} berhasil dihapus secara permanen.");
    }

    public function updateAffiliateGroup(Request $request, $id)
    {
        $request->validate([
            'level' => 'required|in:inner,outer',
        ]);

        $affiliate = Affiliate::findOrFail($id);
        $affiliate->update(['level' => $request->level]);

        return back()->with('success', "Grup affiliate {$affiliate->user->name} berhasil diperbarui ke " . ucfirst($request->level) . ".");
    }

    public function bulkActionAffiliates(Request $request)
    {
        $ids = $request->input('ids', []);
        $action = $request->input('action');

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada affiliate yang dipilih.');
        }

        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    $affiliate = Affiliate::find($id);
                    if ($affiliate) {
                        $user = $affiliate->user;
                        $affiliate->commissions()->delete();
                        $affiliate->payouts()->delete();
                        $affiliate->links()->delete();
                        $affiliate->delete();
                        if ($user) $user->delete();
                    }
                }
                $message = count($ids) . " affiliate berhasil dihapus secara permanen.";
                break;
            
            case 'verify':
                $count = 0;
                foreach ($ids as $id) {
                    $affiliate = Affiliate::find($id);
                    if ($affiliate && $affiliate->user && !$affiliate->user->hasVerifiedEmail()) {
                        $affiliate->user->markEmailAsVerified();
                        $affiliate->update(['status' => 'active']);
                        $count++;
                    }
                }
                $message = "$count affiliate berhasil diverifikasi.";
                break;

            case 'set_inner':
                Affiliate::whereIn('affiliate_id', $ids)->update(['level' => 'inner']);
                $message = count($ids) . " affiliate berhasil diubah ke grup Inner.";
                break;

            case 'set_outer':
                Affiliate::whereIn('affiliate_id', $ids)->update(['level' => 'outer']);
                $message = count($ids) . " affiliate berhasil diubah ke grup Outer.";
                break;

            default:
                return back()->with('error', 'Aksi massal tidak valid.');
        }

        return back()->with('success', $message);
    }
    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }
}
