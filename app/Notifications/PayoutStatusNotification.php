<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payout;

class PayoutStatusNotification extends Notification
{
    use Queueable;

    protected $payout;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payout $payout, string $status)
    {
        $this->payout = $payout;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $messages = [
            'approved' => 'Permintaan penarikan Anda sebesar Rp ' . number_format($this->payout->total_amount, 0, ',', '.') . ' telah disetujui!',
            'rejected' => 'Permintaan penarikan Anda sebesar Rp ' . number_format($this->payout->total_amount, 0, ',', '.') . ' ditolak.',
            'completed' => 'Pembayaran sebesar Rp ' . number_format($this->payout->total_amount, 0, ',', '.') . ' telah berhasil dikirim!',
        ];

        $titles = [
            'approved' => 'Penarikan Disetujui',
            'rejected' => 'Penarikan Ditolak',
            'completed' => 'Pembayaran Berhasil',
        ];

        $icons = [
            'approved' => 'fas fa-check-circle',
            'rejected' => 'fas fa-times-circle',
            'completed' => 'fas fa-money-bill-wave',
        ];

        return [
            'title' => $titles[$this->status] ?? 'Update Penarikan',
            'message' => $messages[$this->status] ?? 'Status penarikan Anda telah diperbarui',
            'icon' => $icons[$this->status] ?? 'fas fa-info-circle',
            'url' => route('affiliate.payouts'),
            'payout_id' => $this->payout->payout_id,
            'amount' => $this->payout->total_amount,
            'status' => $this->status,
        ];
    }
}
