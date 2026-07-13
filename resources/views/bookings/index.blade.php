<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lịch sử Đặt sân của tôi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                    
                    @if (session('status'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if($bookings->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Bạn chưa có đơn đặt sân nào.</p>
                            <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Đi đặt sân ngay</a>
                        </div>
                    @else
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Mã đơn</th>
                                    <th class="px-6 py-3">Sân bóng</th>
                                    <th class="px-6 py-3">Thời gian đá</th>
                                    <th class="px-6 py-3">Tổng tiền</th>
                                    <th class="px-6 py-3">Trạng thái</th>
                                    <th class="px-6 py-3 text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-bold">
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                #{{ $booking->id }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $booking->field->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="text-green-600 font-medium">{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}</span>
                                            <br>
                                            <span class="text-red-500 text-xs">đến {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                                        </td>
                                        <td class="px-6 py-4 font-bold">{{ number_format($booking->total_price, 0, ',', '.') }} đ</td>
                                        <td class="px-6 py-4">
                                            @if($booking->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Chờ xác nhận</span>
                                            @elseif($booking->status == 'confirmed')
                                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Đã xác nhận</span>
                                            @elseif($booking->status == 'completed')
                                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Hoàn tất</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 flex justify-center">
                                            @if($booking->status == 'pending')
                                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn đặt sân này không?')">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="text-red-500 hover:text-white hover:bg-red-600 border border-red-500 px-3 py-1 rounded text-xs font-semibold transition-colors">
                                                        Hủy đơn
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>