<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPayoutRequestNotification extends Notification
{
    use Queueable;

    public $payout;

    /**
     * Create a new notification instance.
     */
    public function __construct($payout)
    {
        $this->payout = $payout;
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
            'type' => 'payout',
            'title' => 'New Payout Request',
            'message' => 'Payout request of Rp ' . number_format($this->payout->total_amount, 0, ',', '.') . ' from ' . $this->payout->affiliate->user->name,
            'payout_id' => $this->payout->payout_id,
            'amount' => $this->payout->total_amount,
        ];
    }
}
