<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Aliziodev\IndonesiaRegions\Models\IndonesiaRegion;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        // Provinces don't have dots in code (e.g., "11", "64")
        $provinces = IndonesiaRegion::whereRaw("code NOT LIKE '%.%'")
            ->orderBy('name')
            ->get(['code', 'name']);
        
        return view('affiliate.profile', compact('user', 'provinces'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'province_id' => 'nullable|string',
            'city_id' => 'nullable|string',
            'district_id' => 'nullable|string',
            'village_id' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'address_detail' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $data = $request->only([
            'name',
            'phone', 
            'province_id', 
            'city_id', 
            'district_id', 
            'village_id', 
            'postal_code', 
            'address_detail',
            'bank_account'
        ]);

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    // AJAX Endpoints for cascading dropdowns
    public function getCities($provinceCode)
    {
        // Cities have format: {province}.{city} (e.g., "11.01", "64.01")
        // Match pattern: exactly one dot, starts with province code
        $cities = IndonesiaRegion::where('code', 'like', $provinceCode . '.%')
            ->whereRaw("code NOT LIKE '%" . $provinceCode . ".%.%'") // Exclude districts/villages
            ->orderBy('name')
            ->get(['code', 'name']);
        
        return response()->json($cities);
    }

    public function getDistricts($cityCode)
    {
        // Districts have format: {province}.{city}.{district} (e.g., "11.01.01")
        // Match pattern: exactly two dots, starts with city code
        $districts = IndonesiaRegion::where('code', 'like', $cityCode . '.%')
            ->whereRaw("LENGTH(code) - LENGTH(REPLACE(code, '.', '')) = 2") // Exactly 2 dots
            ->orderBy('name')
            ->get(['code', 'name']);
        
        return response()->json($districts);
    }

    public function getVillages($districtCode)
    {
        // Villages have format: {province}.{city}.{district}.{village} (e.g., "11.01.01.2001")
        // Match pattern: exactly three dots, starts with district code
        $villages = IndonesiaRegion::where('code', 'like', $districtCode . '.%')
            ->whereRaw("LENGTH(code) - LENGTH(REPLACE(code, '.', '')) = 3") // Exactly 3 dots
            ->orderBy('name')
            ->get(['code', 'name', 'postal_code']);
        
        return response()->json($villages);
    }
}
