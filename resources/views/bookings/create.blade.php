<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('fields.show', $field->id) }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tiến hành đặt sân: ') }} {{ $field->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                
                <form action="{{ route('bookings.store', $field->id) }}" method="POST">
                    @csrf

                    <div class="mb-8 border-b pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">1. Chọn thời gian đá</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_time" class="block text-sm font-bold text-gray-700 mb-2">Giờ bắt đầu</label>
                                <input type="datetime-local" name="start_time" id="start_time" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                       required>
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-bold text-gray-700 mb-2">Giờ kết thúc</label>
                                <input type="datetime-local" name="end_time" id="end_time" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                       required>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">* Lưu ý: Giá thuê sân là <span class="font-bold text-red-500">{{ number_format($field->price_per_hour, 0, ',', '.') }}đ</span> / giờ.</p>
                    </div>

                    <div class="mb-8 border-b pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">2. Dịch vụ đi kèm (Tùy chọn)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($services as $service)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 hover:bg-gray-100 transition">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="services[{{ $service->id }}][id]" value="{{ $service->id }}" id="service_{{ $service->id }}" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-5 h-5">
                                        <label for="service_{{ $service->id }}" class="ml-3 font-semibold text-gray-700 text-sm">
                                            {{ $service->name }} 
                                            <span class="block text-xs text-red-500 font-bold mt-0.5">{{ number_format($service->price, 0, ',', '.') }}đ</span>
                                        </label>
                                    </div>
                                    <div class="w-20">
                                        <input type="number" name="services[{{ $service->id }}][quantity]" value="1" min="1" class="w-full rounded-md border-gray-300 text-sm text-center py-1">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">3. Phương thức thanh toán</h3>
                        <div class="flex gap-4">
                            <label class="flex items-center bg-gray-50 p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-100 transition flex-1">
                                <input type="radio" name="payment_method" value="cash" checked class="text-blue-600 focus:ring-blue-500 w-5 h-5">
                                <span class="ml-3 font-bold text-gray-700 text-sm">Thanh toán tiền mặt tại sân</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t pt-6">
                        <a href="{{ route('fields.show', $field->id) }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg font-semibold transition">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Xác nhận Đặt sân
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>