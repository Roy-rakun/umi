<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MayarService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $environment = $settings['mayar_environment'] ?? 'sandbox';
        $this->apiKey = $settings['mayar_api_key'] ?? '';

        $this->baseUrl = $environment === 'production' 
            ? 'https://api.mayar.id/hl/v1' 
            : 'https://api.mayar.club/hl/v1'; // Sandbox URL might differ, check docs/testing
    }

    public function createPaymentLink($order, $customerName, $customerEmail)
    {
        if (empty($this->apiKey)) {
            return null;
        }

        // Endpoint: /payment/create
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/payment/create', [
            'amount' => (int) $order->amount,
            'description' => 'Payment for Order #' . $order->order_id,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'redirect_url' => route('home'), // Return to home after payment
            'external_id' => $order->order_id, // Link our ID
        ]);

        if ($response->successful()) {
            return $response->json('data');
        }

        return null;
    }
}
