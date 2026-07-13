<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Đặt sân: ') }} {{ $field->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">Thông tin đặt chỗ</h3>
                <p class="mb-6 text-gray-600">Giá mỗi giờ: <span class="font-bold text-red-500">{{ number_format($field->price_per_hour, 0, ',', '.') }} VNĐ</span></p>

                <form action="{{ route('bookings.store', $field->id) }}" method="POST">
                    @csrf

                    <!-- Chọn Giờ -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="start_time" :value="__('Giờ bắt đầu đá')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="datetime-local" name="start_time" required />
                        </div>
                        <div>
                            <x-input-label for="end_time" :value="__('Giờ kết thúc')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" type="datetime-local" name="end_time" required />
                        </div>
                    </div>

                    <!-- Dịch vụ thêm (Tuỳ chọn) -->
                    <h3 class="text-lg font-bold text-gray-900 mb-4 mt-8">Dịch vụ đi kèm (Tùy chọn)</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 border-t border-b py-4 border-gray-200">
                        @foreach ($services as $service)
                            <div class="flex items-center justify-between">
                                <label class="flex items-center">
                                    <input type="checkbox" name="services[{{ $service->id }}][id]" value="{{ $service->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                    <span class="ml-2 text-sm text-gray-700">{{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }}đ)</span>
                                </label>
                                <input type="number" name="services[{{ $service->id }}][quantity]" min="1" placeholder="Số lượng" class="border-gray-300 rounded-md shadow-sm w-24 text-sm disabled:opacity-50">
                            </div>
                        @endforeach
                    </div>

                    <!-- Nút Submit -->
                    <div class="flex items-center justify-between mt-8 pt-4 border-t border-gray-200">
                        <div class="text-lg">
                            Tổng tiền tạm tính: <span id="total_price_display" class="font-bold text-red-600 text-2xl">0 VNĐ</span>
                        </div>
                        <div class="flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 mr-4">Hủy bỏ</a>
                            <x-primary-button>
                                {{ __('Xác nhận đặt sân') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pricePerHour = {{ $field->price_per_hour }};
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            const serviceCheckboxes = document.querySelectorAll('input[type="checkbox"]');
            const serviceQuantities = document.querySelectorAll('input[type="number"]');
            const totalDisplay = document.getElementById('total_price_display');

            function calculateTotal() {
                let total = 0;

                // 1. Tính tiền giờ đá
                if (startTimeInput.value && endTimeInput.value) {
                    const start = new Date(startTimeInput.value);
                    const end = new Date(endTimeInput.value);
                    
                    if (end > start) {
                        const diffInHours = (end - start) / (1000 * 60 * 60);
                        total += diffInHours * pricePerHour;
                    }
                }

                // 2. Tính tiền dịch vụ
                serviceCheckboxes.forEach((checkbox, index) => {
                    const quantityInput = serviceQuantities[index];
                    
                    // Nếu checkbox được tích, cho phép nhập số lượng (mặc định là 1)
                    if (checkbox.checked) {
                        quantityInput.disabled = false;
                        if (!quantityInput.value) quantityInput.value = 1;
                        
                        // Lấy giá dịch vụ từ text (ví dụ: cắt chuỗi "10.000đ" để lấy số 10000)
                        const priceText = checkbox.nextElementSibling.innerText;
                        const priceMatches = priceText.match(/\(([\d.,]+)đ\)/);
                        if (priceMatches) {
                            const servicePrice = parseInt(priceMatches[1].replace(/[.,]/g, ''));
                            total += servicePrice * parseInt(quantityInput.value);
                        }
                    } else {
                        quantityInput.disabled = true;
                        quantityInput.value = '';
                    }
                });

                // Hiển thị ra màn hình
                totalDisplay.innerText = new Intl.NumberFormat('vi-VN').format(total) + ' VNĐ';
            }

            // Gắn sự kiện lắng nghe thay đổi
            startTimeInput.addEventListener('change', calculateTotal);
            endTimeInput.addEventListener('change', calculateTotal);
            serviceCheckboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
            serviceQuantities.forEach(input => input.addEventListener('input', calculateTotal));
        });
    </script>
</x-app-layout>