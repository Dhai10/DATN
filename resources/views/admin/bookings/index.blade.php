<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Đặt sân') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hiển thị thông báo thành công -->
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Mã Đơn</th>
                                <th scope="col" class="px-6 py-3">Khách hàng</th>
                                <th scope="col" class="px-6 py-3">Sân bóng</th>
                                <th scope="col" class="px-6 py-3">Thời gian đá</th>
                                <th scope="col" class="px-6 py-3">Tổng tiền</th>
                                <th scope="col" class="px-6 py-3">Trạng thái</th>
                                <th scope="col" class="px-6 py-3 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold">#{{ $booking->id }}</td>
                                    <td class="px-6 py-4">{{ $booking->user->name ?? 'Khách' }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $booking->field->name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-green-600 font-medium">{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}</div>
                                        <div class="text-red-500 font-medium">đến {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold">{{ number_format($booking->total_price, 0, ',', '.') }} đ</td>
                                    <td class="px-6 py-4">
                                        @if($booking->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Chờ duyệt</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Đã xác nhận</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Đã đá xong</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex gap-2 justify-center">
                                        <!-- Form Duyệt -->
                                        @if($booking->status == 'pending')
                                            <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-xs">Duyệt</button>
                                            </form>
                                        @endif

                                        <!-- Form Hoàn thành (Thu tiền) -->
                                        @if($booking->status == 'confirmed')
                                            <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-xs" onclick="return confirm('Xác nhận khách đã đá xong và thu tiền?')">Hoàn thành</button>
                                            </form>
                                        @endif

                                        <!-- Form Hủy -->
                                        @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                            <form action="{{ route('admin.bookings.update_status', $booking->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-xs" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn này?')">Hủy</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Phân trang -->
                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>