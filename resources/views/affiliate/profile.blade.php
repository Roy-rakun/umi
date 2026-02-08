@extends('layouts.affiliate')
@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-surface rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-2xl bg-[#FFF0F0] flex items-center justify-center text-[#7D2E35] mr-5">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-[#2C3E50] mb-1">Edit Profile</h3>
                    <p class="text-xs text-gray-400 font-medium tracking-wide">Kelola informasi akun Anda</p>
                </div>
            </div>
        </div>

        <form action="{{ route('affiliate.profile.update') }}" method="POST" class="p-8">
            @csrf
            
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            <!-- Basic Info -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-[#2C3E50] mb-4 pb-2 border-b border-gray-100">Informasi Dasar</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" 
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7D2E35] focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Email</label>
                        <input type="email" value="{{ $user->email }}" readonly 
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500 cursor-not-allowed">
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" placeholder="08xx xxxx xxxx"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7D2E35] focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Rekening Bank</label>
                        <input type="text" name="bank_account" value="{{ $user->bank_account }}" placeholder="BCA - 1234567890 a/n John Doe"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7D2E35] focus:border-transparent transition-all">
                        <p class="text-xs text-gray-400 mt-1">Format: Bank - Nomor Rekening a/n Nama Pemilik</p>
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-[#2C3E50] mb-4 pb-2 border-b border-gray-100">Alamat Lengkap</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Province -->
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Provinsi</label>
                        <select name="province_id" id="province" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7D2E35] focus:border-transparent transition-all">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->code }}" {{ $user->province_id == $province->code ? 'selected' : '' }}>{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Kota/Kabupaten</label>
                        <select name="city_id" id="city" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7D2E35] focus:border-transparent transition-all" {{ $user->city_id ? '' : 'disabled' }}>
                            <option value="">Pilih Kota/Kabupaten</option>
                        </select>
                    </div>

                    <!-- District -->
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Kecamatan</label>
                        <select name="district_id" id="district" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7D2E35] focus:border-transparent transition-all" {{ $user->district_id ? '' : 'disabled' }}>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>

                    <!-- Village -->
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Kelurahan/Desa</label>
                        <select name="village_id" id="village" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7D2E35] focus:border-transparent transition-all" {{ $user->village_id ? '' : 'disabled' }}>
                            <option value="">Pilih Kelurahan/Desa</option>
                        </select>
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label class="block text-sm font-bold text-[#2C3E50] mb-2">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ $user->postal_code }}" readonly class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-600 cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1">Otomatis terisi dari kelurahan</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-[#2C3E50] mb-2">Detail Alamat Lengkap</label>
                <textarea name="address_detail" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, dll."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#7D2E35] focus:border-transparent transition-all">{{ $user->address_detail }}</textarea>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-50">
                <button type="submit" class="bg-[#7D2E35] text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-[#632429] transition-colors shadow-sm">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    const villageSelect = document.getElementById('village');
    const postalCodeInput = document.getElementById('postal_code');

    // Store initial values for edit mode
    const initialValues = {
        city: '{{ $user->city_id }}',
        district: '{{ $user->district_id }}',
        village: '{{ $user->village_id }}'
    };

    function resetSelect(select, placeholder = 'Pilih') {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    }

    async function loadOptions(url, targetSelect, placeholder, selectedValue = null) {
        console.log('Loading options from:', url);
        try {
            const response = await fetch(url);
            const data = await response.json();
            console.log('Received data:', data);
            
            resetSelect(targetSelect, placeholder);
            
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.code;
                option.textContent = item.name;
                if (item.postal_code) {
                    option.dataset.postal = item.postal_code;
                }
                if (selectedValue && item.code == selectedValue) {
                    option.selected = true;
                }
                targetSelect.appendChild(option);
            });
            
            targetSelect.disabled = false;
            console.log('Dropdown enabled, options count:', data.length);
        } catch (error) {
            console.error('Error loading options from', url, ':', error);
        }
    }

    // Province change
    provinceSelect.addEventListener('change', function() {
        resetSelect(citySelect, 'Pilih Kota/Kabupaten');
        resetSelect(districtSelect, 'Pilih Kecamatan');
        resetSelect(villageSelect, 'Pilih Kelurahan/Desa');
        postalCodeInput.value = '';
        
        if (this.value) {
            loadOptions(`/api/regions/cities/${this.value}`, citySelect, 'Pilih Kota/Kabupaten');
        }
    });

    // City change
    citySelect.addEventListener('change', function() {
        resetSelect(districtSelect, 'Pilih Kecamatan');
        resetSelect(villageSelect, 'Pilih Kelurahan/Desa');
        postalCodeInput.value = '';

        if (this.value) {
            loadOptions(`/api/regions/districts/${this.value}`, districtSelect, 'Pilih Kecamatan');
        }
    });

    // District change
    districtSelect.addEventListener('change', function() {
        resetSelect(villageSelect, 'Pilih Kelurahan/Desa');
        postalCodeInput.value = '';

        if (this.value) {
            loadOptions(`/api/regions/villages/${this.value}`, villageSelect, 'Pilih Kelurahan/Desa');
        }
    });

    // Village change - auto-fill postal code
    villageSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.postal) {
            postalCodeInput.value = selectedOption.dataset.postal;
        } else {
            postalCodeInput.value = '';
        }
    });

    // Initial load for edit mode
    if (provinceSelect.value && initialValues.city) {
        loadOptions(`/api/regions/cities/${provinceSelect.value}`, citySelect, 'Pilih Kota/Kabupaten', initialValues.city).then(() => {
            if (initialValues.district) {
                loadOptions(`/api/regions/districts/${initialValues.city}`, districtSelect, 'Pilih Kecamatan', initialValues.district).then(() => {
                    if (initialValues.village) {
                        loadOptions(`/api/regions/villages/${initialValues.district}`, villageSelect, 'Pilih Kelurahan/Desa', initialValues.village);
                    }
                });
            }
        });
    }
});
</script>
@endsection
