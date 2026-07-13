<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lịch sử Giao dịch') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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
                                <th class="px-6 py-3">Mã GD</th>
                                <th class="px-6 py-3">Khách hàng</th>
                                <th class="px-6 py-3">Mã Đơn (Booking)</th>
                                <th class="px-6 py-3">Số tiền</th>
                                <th class="px-6 py-3">Phương thức</th>
                                <th class="px-6 py-3">Trạng thái</th>
                                <th class="px-6 py-3 text-center">Cập nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-900">#PAY-{{ $payment->id }}</td>
                                    <td class="px-6 py-4">{{ $payment->booking->user->name ?? 'Khách vãng lai' }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:underline">
                                            #{{ $payment->booking_id }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-red-500">{{ number_format($payment->amount, 0, ',', '.') }} đ</td>
                                    <td class="px-6 py-4 uppercase font-semibold">
                                        {{ $payment->payment_method }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($payment->payment_status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Chưa thanh toán</span>
                                        @elseif($payment->payment_status == 'paid')
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Đã thanh toán</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Thất bại</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex justify-center">
                                        @if($payment->payment_status == 'pending')
                                            <form action="{{ route('admin.payments.update_status', $payment->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="payment_status" value="paid">
                                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-xs" onclick="return confirm('Xác nhận đã nhận được tiền từ khách hàng này?')">
                                                    Đã thu tiền
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">- Hoàn tất -</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>