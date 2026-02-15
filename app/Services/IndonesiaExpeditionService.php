<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IndonesiaExpeditionService
{
    protected $apiUrl;
    protected $apiKey;
    protected $originVillageCode;

    public function __construct()
    {
        $settings = Setting::all()->pluck('value', 'key');
        
        // API Indonesia Expedition Cost from docs.api.co.id
        // Base URL: https://use.api.co.id/expedition
        $this->apiUrl = 'https://use.api.co.id/expedition';
        $this->apiKey = $settings['indonesia_expedition_api_key'] ?? 'Bp3gPph4yGCL3SYBrEVBLXvMZpXUs0RibG26nwtE45b7XDnvuu';
        
        // Origin village code - use origin_village_id from settings
        $this->originVillageCode = $settings['origin_village_id'] ?? null;
    }

    /**
     * Get all provinces
     */
    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get($this->apiUrl . '/provinces');

            Log::info('API Provinces Response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'])) {
                    return $data['data'];
                }
                
                if (is_array($data)) {
                    return $data;
                }
            }
        } catch (\Exception $e) {
            Log::error('Indonesia Expedition API Error (Provinces): ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Get cities by province ID
     */
    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get($this->apiUrl . '/cities', [
                'province_code' => $provinceId
            ]);

            Log::info('API Cities Response', ['province' => $provinceId, 'status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'])) {
                    return $data['data'];
                }
                
                if (is_array($data)) {
                    return $data;
                }
            }
        } catch (\Exception $e) {
            Log::error('Indonesia Expedition API Error (Cities): ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Get districts by city code
     */
    public function getDistricts($cityCode)
    {
        try {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get($this->apiUrl . '/districts', [
                'city_code' => $cityCode
            ]);

            Log::info('API Districts Response', ['city' => $cityCode, 'status' => $response->status()]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'])) {
                    return $data['data'];
                }
                
                if (is_array($data)) {
                    return $data;
                }
            }
        } catch (\Exception $e) {
            Log::error('Indonesia Expedition API Error (Districts): ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Get villages by district code
     */
    public function getVillages($districtCode)
    {
        try {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get($this->apiUrl . '/villages', [
                'district_code' => $districtCode
            ]);

            Log::info('API Villages Response', ['district' => $districtCode, 'status' => $response->status()]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'])) {
                    return $data['data'];
                }
                
                if (is_array($data)) {
                    return $data;
                }
            }
        } catch (\Exception $e) {
            Log::error('Indonesia Expedition API Error (Villages): ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Get all cities (without province filter)
     */
    public function getAllCities()
    {
        try {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get($this->apiUrl . '/cities');

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'])) {
                    return $data['data'];
                }
                
                if (is_array($data)) {
                    return $data;
                }
            }
        } catch (\Exception $e) {
            Log::error('Indonesia Expedition API Error (All Cities): ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Convert village code format from "31.73.05.1006" to "3173051006"
     * API expects 10-digit code without dots
     */
    protected function normalizeVillageCode($code)
    {
        if (empty($code)) {
            return null;
        }
        
        // Remove dots and any non-numeric characters
        $normalized = preg_replace('/[^0-9]/', '', $code);
        
        return $normalized;
    }

    /**
     * Calculate shipping cost - Only J&T Express
     * Uses village codes for origin and destination
     */
    public function calculateCost($destinationVillageCode, $weight)
    {
        if (empty($this->apiKey)) {
            Log::warning('Indonesia Expedition API Key missing');
            return $this->getFallbackShipping($weight);
        }

        if (empty($this->originVillageCode)) {
            Log::warning('Origin Village Code not set in settings');
            return $this->getFallbackShipping($weight);
        }

        try {
            // Weight in kg (API expects kg, not grams)
            $weightKg = max(1, ceil($weight / 1000));
            
            // Normalize village codes (remove dots)
            $originCode = $this->normalizeVillageCode($this->originVillageCode);
            $destinationCode = $this->normalizeVillageCode($destinationVillageCode);

            $response = Http::timeout(15)->withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get($this->apiUrl . '/shipping-cost', [
                'origin_village_code' => $originCode,
                'destination_village_code' => $destinationCode,
                'weight' => $weightKg,
            ]);

            Log::info('Indonesia Expedition Cost Request', [
                'origin_village' => $this->originVillageCode,
                'destination_village' => $destinationVillageCode,
                'weight' => $weightKg,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Handle the API response format: data.couriers
                if (isset($data['data']['couriers'])) {
                    $parsed = $this->parseApiResponse($data['data']['couriers']);
                    if (!empty($parsed)) {
                        return $parsed;
                    }
                }
                
                // Direct couriers array
                if (isset($data['couriers'])) {
                    $parsed = $this->parseApiResponse($data['couriers']);
                    if (!empty($parsed)) {
                        return $parsed;
                    }
                }
                
                // Fallback: try data as array
                if (is_array($data)) {
                    $parsed = $this->parseApiResponse($data);
                    if (!empty($parsed)) {
                        return $parsed;
                    }
                }
            }
            
            // If API returned error or empty, use fallback
            Log::warning('Indonesia Expedition API returned empty or error, using fallback', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return $this->getFallbackShipping($weight);
            
        } catch (\Exception $e) {
            Log::error('Indonesia Expedition API Error (Cost): ' . $e->getMessage());
            return $this->getFallbackShipping($weight);
        }
    }

    /**
     * Parse API response format
     * Only returns J&T Express as per requirement
     */
    protected function parseApiResponse($results)
    {
        $shippingOptions = [];
        
        foreach ($results as $item) {
            // Only include J&T Express (courier_code = "JT")
            $courierCode = strtoupper($item['courier_code'] ?? $item['courier'] ?? '');
            
            if ($courierCode === 'JT' || $courierCode === 'JNT' || $courierCode === 'J&T') {
                $shippingOptions[] = [
                    'courier' => $item['courier_name'] ?? 'J&T Express',
                    'courier_code' => 'jnt',
                    'service' => 'REG',
                    'description' => 'Regular Service',
                    'cost' => (int) ($item['price'] ?? $item['cost'] ?? 0),
                    'etd' => $item['estimation'] ?? $item['etd'] ?? '-',
                ];
            }
        }
        
        return $shippingOptions;
    }

    /**
     * Get fallback shipping rates when API is unavailable
     * Uses flat rate based on weight
     */
    protected function getFallbackShipping($weight)
    {
        // J&T Express flat rate calculation (approximate)
        // Base rate: Rp 15,000 for first 1kg
        // Additional: Rp 5,000 per kg
        $baseRate = 15000;
        $additionalRate = 5000;
        
        $weightKg = max(1, ceil($weight / 1000)); // Round up to nearest kg, min 1kg
        
        $cost = $baseRate + ($weightKg - 1) * $additionalRate;
        
        return [
            [
                'courier' => 'J&T Express',
                'courier_code' => 'jnt',
                'service' => 'REG',
                'description' => 'Layanan Reguler',
                'cost' => $cost,
                'etd' => '3-5',
            ],
            [
                'courier' => 'J&T Express',
                'courier_code' => 'jnt',
                'service' => 'YES',
                'description' => 'Yakin Esok Sampai',
                'cost' => $cost + 10000, // More expensive for express
                'etd' => '1-2',
            ],
        ];
    }

    /**
     * Parse rajaongkir-style results
     */
    protected function parseRajaongkirResults($results)
    {
        $shippingOptions = [];
        
        foreach ($results as $courier) {
            // Only process J&T Express
            $courierCode = strtolower($courier['code'] ?? '');
            if ($courierCode === 'jnt' || $courierCode === 'j&t') {
                foreach ($courier['costs'] ?? [] as $service) {
                    $costData = $service['cost'][0] ?? null;
                    if ($costData) {
                        $shippingOptions[] = [
                            'courier' => 'J&T Express',
                            'courier_code' => 'jnt',
                            'service' => $service['service'] ?? 'REG',
                            'description' => $service['description'] ?? '',
                            'cost' => (int) ($costData['value'] ?? 0),
                            'etd' => $costData['etd'] ?? '-',
                        ];
                    }
                }
            }
        }
        
        return $shippingOptions;
    }

    /**
     * Parse direct-style results
     */
    protected function parseDirectResults($results)
    {
        $shippingOptions = [];
        
        // Check if it's a courier array
        foreach ($results as $item) {
            if (isset($item['code'])) {
                $courierCode = strtolower($item['code']);
                if ($courierCode === 'jnt' || $courierCode === 'j&t') {
                    foreach ($item['costs'] ?? [] as $service) {
                        $costData = $service['cost'][0] ?? $service;
                        $shippingOptions[] = [
                            'courier' => 'J&T Express',
                            'courier_code' => 'jnt',
                            'service' => $service['service'] ?? ($costData['service'] ?? 'REG'),
                            'description' => $service['description'] ?? '',
                            'cost' => (int) ($costData['value'] ?? $costData['cost'] ?? 0),
                            'etd' => $costData['etd'] ?? '-',
                        ];
                    }
                }
            } elseif (isset($item['service'])) {
                // Direct service format
                $shippingOptions[] = [
                    'courier' => 'J&T Express',
                    'courier_code' => 'jnt',
                    'service' => $item['service'] ?? 'REG',
                    'description' => $item['description'] ?? '',
                    'cost' => (int) ($item['cost'] ?? $item['value'] ?? 0),
                    'etd' => $item['etd'] ?? '-',
                ];
            }
        }
        
        return $shippingOptions;
    }

    /**
     * Get single shipping cost (first/best option)
     */
    public function getShippingCost($destinationCityId, $weight)
    {
        $options = $this->calculateCost($destinationCityId, $weight);
        
        if (!empty($options)) {
            return $options[0]; // Return first option
        }
        
        return null;
    }
}
