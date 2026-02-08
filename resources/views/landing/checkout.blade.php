@extends('layouts.app') 
@section('title', 'Checkout - ' . $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">
        
        <!-- Product Summary (Left/Top) -->
        <div class="md:w-1/3 bg-gray-50 p-6 border-r border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Order Summary</h3>
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 mr-4">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700">{{ $product->name }}</h4>
                    <span class="text-sm text-gray-500">{{ ucfirst($product->type) }} Product</span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span>Price</span>
                    <span class="font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                
                @if($product->type === 'physical')
                <div class="flex justify-between text-sm" id="shipping-row" style="display: none;">
                    <span>Shipping (J&T)</span>
                    <span class="font-medium" id="shipping-cost">Rp 0</span>
                </div>
                @endif
                
                <div class="border-t border-gray-200 pt-2 flex justify-between font-bold text-lg mt-2">
                    <span>Total</span>
                    <span class="text-[#8B7355]" id="total-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form (Right/Bottom) -->
        <div class="md:w-2/3 p-6">
            <h2 class="text-2xl font-bold text-[#2C3E50] mb-6">Checkout Details</h2>
            
            <form action="{{ route('checkout.process', $product->product_id) }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="ref" value="{{ request('ref') }}">
                
                <!-- Customer Info -->
                <div class="mb-6">
                    <h4 class="text-sm uppercase tracking-wide text-gray-500 font-semibold mb-3">Contact Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" required class="w-full border border-gray-300 rounded p-2 focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="Your Name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" required class="w-full border border-gray-300 rounded p-2 focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="you@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" required class="w-full border border-gray-300 rounded p-2 focus:ring-[#8B7355] focus:border-[#8B7355]" placeholder="08...">
                        </div>
                    </div>
                </div>

                <!-- Shipping Address (Physical Only) -->
                @if($product->type === 'physical')
                <div class="mb-6">
                    <h4 class="text-sm uppercase tracking-wide text-gray-500 font-semibold mb-3">Shipping Address</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Province</label>
                            <select name="province_id" id="province" required class="w-full border border-gray-300 rounded p-2 focus:ring-[#8B7355] focus:border-[#8B7355]">
                                <option value="">Select Province</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->code }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <select name="city_id" id="city" required class="w-full border border-gray-300 rounded p-2 focus:ring-[#8B7355] focus:border-[#8B7355]" disabled>
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                            <select name="district_id" id="district" required class="w-full border border-gray-300 rounded p-2 focus:ring-[#8B7355] focus:border-[#8B7355]" disabled>
                                <option value="">Select District</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Village</label>
                            <select name="village_id" id="village" required class="w-full border border-gray-300 rounded p-2 focus:ring-[#8B7355] focus:border-[#8B7355]" disabled>
                                <option value="">Select Village</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" readonly class="w-full bg-gray-50 border border-gray-300 rounded p-2 text-gray-600">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                        <textarea name="address_detail" required class="w-full border border-gray-300 rounded p-2 focus:ring-[#8B7355] focus:border-[#8B7355]" rows="2" placeholder="Street, Number, RT/RW"></textarea>
                    </div>

                    <!-- Hidden Fields for Shipping -->
                    <input type="hidden" name="shipping_cost" id="input_shipping_cost" value="0">
                    <input type="hidden" name="weight" value="{{ $product->weight }}">
                    
                    <div id="courier-loading" class="hidden text-sm text-gray-500 mt-2">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Calculating Shipping Cost...
                    </div>
                    <div id="courier-error" class="hidden text-sm text-red-500 mt-2"></div>
                </div>
                @endif

                <button type="submit" id="submit-btn" class="w-full bg-[#7D2E35] text-white font-bold py-3 rounded-lg hover:bg-[#5D2228] transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-md">
                    Complete Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isPhysical = {{ $product->type === 'physical' ? 'true' : 'false' }};
    if (!isPhysical) return;

    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    const villageSelect = document.getElementById('village'); 
    const postalCodeInput = document.getElementById('postal_code');
    
    const shippingRow = document.getElementById('shipping-row');
    const shippingCostSpan = document.getElementById('shipping-cost');
    const totalPriceSpan = document.getElementById('total-price');
    const inputShippingCost = document.getElementById('input_shipping_cost');
    const submitBtn = document.getElementById('submit-btn');
    const loadingDiv = document.getElementById('courier-loading');
    
    // Total calculation helper
    const productPrice = {{ $product->price }};
    const productWeight = {{ $product->weight }}; 
    let currentShippingCost = 0;
    
    function updateTotalPrice() {
         const total = productPrice + currentShippingCost;
         totalPriceSpan.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
         // Also verify if total text color needs update for theme
         totalPriceSpan.style.color = '#7D2E35'; // Ensure Maroon
    }

    // Region Loaders (Reuse logic or separate file if possible)
    async function loadData(url, targetSelect, defaultText) {
        targetSelect.disabled = true;
        try {
            const response = await fetch(url);
            const data = await response.json();
            
            targetSelect.innerHTML = '<option value="">' + defaultText + '</option>';
            
             if (Array.isArray(data)) {
                 data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.code;
                    option.textContent = item.name;
                    if(item.postal_code) option.dataset.postal = item.postal_code;
                    targetSelect.appendChild(option);
                });
            } else {
                 Object.entries(data).forEach(([code, name]) => {
                    const option = document.createElement('option');
                    option.value = code;
                    option.textContent = name;
                    targetSelect.appendChild(option);
                });
            }
           
            targetSelect.disabled = false;
        } catch (error) {
            console.error('Error loading data:', error);
        }
    }

    provinceSelect.addEventListener('change', function() {
        if(this.value) loadData(`/api/regions/cities/${this.value}`, citySelect, 'Select City');
        citySelect.innerHTML = '<option value="">Select City</option>'; 
        districtSelect.innerHTML = '<option value="">Select District</option>';
        districtSelect.disabled = true;
    });

    citySelect.addEventListener('change', function() {
        if(this.value) loadData(`/api/regions/districts/${this.value}`, districtSelect, 'Select District');
        districtSelect.innerHTML = '<option value="">Select District</option>';
        districtSelect.disabled = true;
    });
    
    // Calculate Shipping when District is Selected
    districtSelect.addEventListener('change', function() {
        if(this.value) {
            loadData(`/api/regions/villages/${this.value}`, villageSelect, 'Select Village');
            calculateShipping();
        }
    });

    villageSelect.addEventListener('change', function() {
         const selectedOption = this.options[this.selectedIndex];
         if (selectedOption && selectedOption.dataset.postal) {
             postalCodeInput.value = selectedOption.dataset.postal;
         }
    });

    async function calculateShipping() {
        const provinceId = provinceSelect.value;
        const cityId = citySelect.value;
        const districtId = districtSelect.value;

        if (!provinceId || !cityId || !districtId) return;

        loadingDiv.classList.remove('hidden');
        submitBtn.disabled = true;
        
        try {
            const response = await fetch('/api/shipping/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    province_id: provinceId,
                    city_id: cityId,
                    district_id: districtId,
                    weight: productWeight
                })
            });

            const result = await response.json();

            if (result.status === 'success') {
                currentShippingCost = result.price;
                inputShippingCost.value = currentShippingCost;
                
                // Update UI
                shippingRow.style.display = 'flex';
                shippingCostSpan.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(currentShippingCost);
                
                const total = productPrice + currentShippingCost;
                totalPriceSpan.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                
                submitBtn.disabled = false;
            } else {
                alert('Shipping calculation failed: ' + (result.message || 'Unknown error'));
                submitBtn.disabled = false; // Allow submit? Maybe not if shipping mandatory
            }
        } catch (error) {
            console.error('Shipping Error:', error);
            alert('Could not calculate shipping cost. Please check internet connection.');
        } finally {
            loadingDiv.classList.add('hidden');
        }
    }
});
</script>
@endsection
