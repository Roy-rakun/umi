<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JntService
{
    protected $apiUrl;
    protected $clientId;
    protected $apiKey;
    protected $senderProvince;
    protected $senderCity;
    protected $senderDistrict;

    public function __construct()
    {
        $settings = Setting::all()->pluck('value', 'key');
        
        $this->apiUrl = 'http://api.jet.co.id/jandttop-iface-web/order/orderAction!index.action'; // Production/Dev URL (Usually same, check credentials)
        
        $this->clientId = $settings['jnt_client_id'] ?? '';
        $this->apiKey = $settings['jnt_api_key'] ?? '';
        
        // Origin Address
        $this->senderProvince = $settings['origin_province'] ?? 'DKI Jakarta';
        $this->senderCity = $settings['origin_city'] ?? 'Jakarta Selatan';
        $this->senderDistrict = $settings['origin_district'] ?? 'Setiabudi';
    }

    public function checkTariff($receiverProvince, $receiverCity, $receiverDistrict, $weight = 1)
    {
        if (empty($this->clientId) || empty($this->apiKey)) {
            Log::warning('J&T Credentials missing');
            return null;
        }

        // 1. Build Logistics Interface JSON
        $logisticsInterface = [
            'senderProvince' => $this->senderProvince,
            'senderCity' => $this->senderCity,
            'receiverProvince' => $receiverProvince,
            'receiverCity' => $receiverCity,
            'receiverDistrict' => $receiverDistrict,
            'weight' => (string) $weight, // String format required often
        ];

        $jsonLogistics = json_encode($logisticsInterface);

        // 2. Create Signature (Base64(MD5(json + key)))
        $dataDigest = base64_encode(md5($jsonLogistics . $this->apiKey, true)); // Binary MD5 usually required for Java interoperability? Docs say MD5 then Base64.
        // Clarification: Usually Java-based APIs expect standard MD5 hex then Base64 OR binary MD5 then Base64.
        // Most J&T integrations use standard MD5 string then Base64: base64_encode(pack('H*', md5($str))) or just base64_encode(md5($str))?
        // Let's try standard MD5 output (hex) -> Base64 first. 
        // Wait, typical Java 'MessageDigest' output is binary. Let's stick to standard practice for these older APIs.
        // Actually, PHP md5($str, true) returns raw binary. base64_encode(raw) is the standard way to match Java's MessageDigest.
        $dataDigest = base64_encode(md5($jsonLogistics . $this->apiKey, true));

        // 3. Send Request
        try {
            $response = Http::asForm()->post($this->apiUrl, [
                'eccommerceid' => $this->clientId,
                'msg_type' => 'PRICEQUERY',
                'logistics_interface' => $jsonLogistics,
                'data_digest' => $dataDigest,
            ]);

            Log::info('J&T Request', [
                'json' => $jsonLogistics,
                'response' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // Response format usually: {"responseitems":[{"price":"10000", ...}]}
                
                if (!empty($data['responseitems'])) {
                    // Return the first valid price
                    return $data['responseitems'][0]['price'] ?? 0;
                }
            }
        } catch (\Exception $e) {
            Log::error('J&T API Error: ' . $e->getMessage());
        }

        return null;
    }
}
