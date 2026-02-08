<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JntService;
use Aliziodev\IndonesiaRegions\Models\Province;
use Aliziodev\IndonesiaRegions\Models\City;
use Aliziodev\IndonesiaRegions\Models\District;

class ShippingController extends Controller
{
    public function calculate(Request $request)
    {
        $request->validate([
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'weight' => 'required|numeric',
        ]);

        // Fetch Names based on IDs
        $province = Province::where('code', $request->province_id)->first()->name ?? '';
        $city = City::where('code', $request->city_id)->first()->name ?? '';
        $district = District::where('code', $request->district_id)->first()->name ?? '';

        // Clean names if necessary (J&T sometimes dislikes "KAB. " or "KOTA ")
        // But let's try raw first or standard cleaning
        // $city = str_replace(['KAB. ', 'KOTA '], '', $city);

        $jntService = new JntService();
        $price = $jntService->checkTariff($province, $city, $district, $request->weight);

        if ($price !== null) {
            return response()->json([
                'status' => 'success',
                'price' => (int) $price,
                'courier' => 'J&T Express'
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Tariff not found'], 404);
    }
}
