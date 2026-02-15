<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IndonesiaExpeditionService;
use Aliziodev\IndonesiaRegions\Models\Province;
use Aliziodev\IndonesiaRegions\Models\City;
use Aliziodev\IndonesiaRegions\Models\District;

class ShippingController extends Controller
{
    protected $expeditionService;

    public function __construct()
    {
        $this->expeditionService = new IndonesiaExpeditionService();
    }

    /**
     * Get all provinces for shipping
     */
    public function getProvinces()
    {
        $provinces = $this->expeditionService->getProvinces();
        
        return response()->json([
            'status' => 'success',
            'data' => $provinces
        ]);
    }

    /**
     * Get cities by province ID
     */
    public function getCities($provinceId)
    {
        $cities = $this->expeditionService->getCities($provinceId);
        
        return response()->json([
            'status' => 'success',
            'data' => $cities
        ]);
    }

    /**
     * Calculate shipping cost - J&T Express only
     * Uses village_code for more accurate shipping calculation
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'destination_village_code' => 'required|string',
            'weight' => 'required|numeric|min:1',
        ]);

        $shippingOptions = $this->expeditionService->calculateCost(
            $request->destination_village_code,
            $request->weight
        );

        if ($shippingOptions && count($shippingOptions) > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $shippingOptions
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Tidak dapat menghitung ongkir. Pastikan kelurahan tujuan valid.'
        ], 404);
    }

    /**
     * Legacy support - Calculate shipping with district names
     */
    public function calculateLegacy(Request $request)
    {
        $request->validate([
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'weight' => 'required|numeric',
        ]);

        // Try to find matching city ID from Indonesia Regions
        $city = \Aliziodev\IndonesiaRegions\Models\City::where('code', $request->city_id)->first();
        
        if (!$city) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kota tidak ditemukan'
            ], 404);
        }

        // Map Indonesia Regions city code to API city ID
        // This mapping may need adjustment based on actual data
        $destinationCityId = $city->code; // Or use a mapping table

        $shippingOptions = $this->expeditionService->calculateCost(
            $destinationCityId,
            $request->weight
        );

        if ($shippingOptions && count($shippingOptions) > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $shippingOptions,
                'price' => $shippingOptions[0]['cost'], // Legacy support
                'courier' => 'J&T Express'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Tariff not found'
        ], 404);
    }
}