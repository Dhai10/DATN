<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết Đơn đặt sân #') }}{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Biên lai thanh toán</h3>
                        <p class="text-sm text-gray-500">Ngày tạo đơn: {{ $booking->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        @if($booking->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-sm font-semibold px-3 py-1 rounded-full border border-yellow-200">Chờ xác nhận</span>
                        @elseif($booking->status == 'confirmed')
                            <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full border border-blue-200">Đã xác nhận</span>
                        @elseif($booking->status == 'completed')
                            <span class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full border border-green-200">Hoàn tất</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-sm font-semibold px-3 py-1 rounded-full border border-red-200">Đã hủy</span>
                        @endif
                    </div>
                </div>

                <div class="p-6 border-b border-gray-200">
                    <h4 class="font-bold text-gray-700 mb-4 uppercase text-sm tracking-wider">Thông tin đặt chỗ</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Sân bóng:</p>
                            <p class="font-semibold text-lg text-gray-900">{{ $booking->field->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Thời gian đá:</p>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }} 
                                <span class="text-gray-500 text-sm ml-1">({{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y') }})</span>
                            </p>
                            @php
                                $start = \Carbon\Carbon::parse($booking->start_time);
                                $end = \Carbon\Carbon::parse($booking->end_time);
                                // Đổi vị trí để luôn trả về số giờ dương
                                $hours = $start->diffInMinutes($end) / 60;
                            @endphp
                            <p class="text-sm text-indigo-600 font-medium mt-1">Tổng thời lượng: {{ $hours }} giờ</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h4 class="font-bold text-gray-700 mb-4 uppercase text-sm tracking-wider">Chi tiết thanh toán</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-600 text-sm">
                                    <th class="pb-2">Nội dung</th>
                                    <th class="pb-2 text-center">Số lượng</th>
                                    <th class="pb-2 text-right">Đơn giá</th>
                                    <th class="pb-2 text-right">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800">
                                <tr class="border-b border-dashed border-gray-200">
                                    <td class="py-3">
                                        <span class="font-medium">Tiền thuê sân ({{ $booking->field->name }})</span>
                                    </td>
                                    <td class="py-3 text-center">{{ $hours }} giờ</td>
                                    <td class="py-3 text-right">{{ number_format($booking->field->price_per_hour, 0, ',', '.') }} đ</td>
                                    <td class="py-3 text-right font-semibold">{{ number_format($hours * $booking->field->price_per_hour, 0, ',', '.') }} đ</td>
                                </tr>

                                @if($booking->services->count() > 0)
                                    @foreach($booking->services as $service)
                                    <tr class="border-b border-dashed border-gray-200 bg-gray-50">
                                        <td class="py-3 pl-2">
                                            <span class="font-medium text-gray-600">{{ $service->name }}</span>
                                        </td>
                                        <td class="py-3 text-center text-gray-600">{{ $service->pivot->quantity }}</td>
                                        <td class="py-3 text-right text-gray-600">{{ number_format($service->pivot->price, 0, ',', '.') }} đ</td>
                                        <td class="py-3 text-right font-semibold text-gray-600">{{ number_format($service->pivot->price * $service->pivot->quantity, 0, ',', '.') }} đ</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="pt-6 text-right font-bold text-lg text-gray-800 uppercase">Tổng cộng:</td>
                                    <td class="pt-6 text-right font-bold text-2xl text-red-600">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-100 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center rounded-b-lg">
                    <div class="mb-4 md:mb-0">
                        <span class="text-sm text-gray-600 mr-2">Trạng thái thanh toán:</span>
                        @if($booking->payment && $booking->payment->payment_status == 'paid')
                            <span class="bg-green-100 text-green-800 font-bold px-3 py-1 rounded text-sm shadow-sm">
                                ĐÃ THANH TOÁN ({{ strtoupper($booking->payment->payment_method) }})
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 font-bold px-3 py-1 rounded text-sm shadow-sm">
                                CHƯA THANH TOÁN
                            </span>
                        @endif
                    </div>
                    
                    <a href="{{ route('bookings.pdf', $booking->id) }}" class="px-6 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition shadow flex items-center gap-1">
                            📥 Tải Hóa đơn (PDF)
                    </a>
                    
                    <a href="{{ route('bookings.index') }}" class="px-6 py-2 bg-gray-800 text-white font-semibold rounded hover:bg-gray-700 transition shadow">
                        Quay lại danh sách
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>