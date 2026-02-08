<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Commission;

class NewCommissionNotification extends Notification
{
    use Queueable;

    protected $commission;

    /**
     * Create a new notification instance.
     */
    public function __construct(Commission $commission)
    {
        $this->commission = $commission;
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
        return [
            'title' => 'Komisi Baru!',
            'message' => 'Anda mendapatkan komisi sebesar Rp ' . number_format($this->commission->commission_amount, 0, ',', '.') . ' dari order #' . $this->commission->order_id,
            'icon' => 'fas fa-money-bill-wave',
            'url' => route('affiliate.commissions'),
            'commission_id' => $this->commission->commission_id,
            'amount' => $this->commission->commission_amount,
        ];
    }
}
