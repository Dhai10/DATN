<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bảng điều khiển Quản trị') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-green-100 uppercase tracking-wider text-sm">Tổng doanh thu</h3>
                        <span class="text-2xl opacity-80">💰</span>
                    </div>
                    <p class="text-3xl font-extrabold">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
                </div>
                
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-blue-100 uppercase tracking-wider text-sm">Tổng đơn đặt sân</h3>
                        <span class="text-2xl opacity-80">📅</span>
                    </div>
                    <p class="text-3xl font-extrabold">{{ $totalBookings }} <span class="text-lg font-normal opacity-80">đơn</span></p>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-purple-100 uppercase tracking-wider text-sm">Khách hàng</h3>
                        <span class="text-2xl opacity-80">👥</span>
                    </div>
                    <p class="text-3xl font-extrabold">{{ $totalUsers }} <span class="text-lg font-normal opacity-80">người</span></p>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-orange-100 uppercase tracking-wider text-sm">Sân bóng hiện có</h3>
                        <span class="text-2xl opacity-80">⚽</span>
                    </div>
                    <p class="text-3xl font-extrabold">{{ $totalFields }} <span class="text-lg font-normal opacity-80">sân</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-4 mb-4">📈 Biểu đồ doanh thu 6 tháng gần nhất</h3>
                    <div class="relative h-80 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-4 mb-4">🛠️ Lối tắt quản lý</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.bookings.index') }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition group border border-gray-200">
                            <span class="font-semibold text-gray-700 group-hover:text-blue-600">Duyệt đơn đặt sân</span>
                            <span class="bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded">&rarr;</span>
                        </a>
                        <a href="{{ route('admin.payments.index') }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-green-50 hover:text-green-600 transition group border border-gray-200">
                            <span class="font-semibold text-gray-700 group-hover:text-green-600">Thu tiền & Hóa đơn</span>
                            <span class="bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded">&rarr;</span>
                        </a>
                        <a href="{{ route('admin.fields.index') }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition group border border-gray-200">
                            <span class="font-semibold text-gray-700 group-hover:text-indigo-600">Quản lý Sân bóng</span>
                            <span class="bg-indigo-100 text-indigo-600 text-xs font-bold px-2 py-1 rounded">&rarr;</span>
                        </a>
                        <a href="{{ route('admin.customers.index') }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition group border border-gray-200">
                            <span class="font-semibold text-gray-700 group-hover:text-purple-600">Tài khoản Khách hàng</span>
                            <span class="bg-purple-100 text-purple-600 text-xs font-bold px-2 py-1 rounded">&rarr;</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            // Lấy mảng dữ liệu từ PHP (Controller) truyền sang JS
            const labels = {!! json_encode($months) !!};
            const data = {!! json_encode($monthlyRevenue) !!};

            new Chart(ctx, {
                type: 'bar', // Dạng biểu đồ cột
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)', // Màu xanh dương Tailwind (blue-500)
                        borderColor: 'rgba(37, 99, 235, 1)', // Viền xanh đậm (blue-600)
                        borderWidth: 1,
                        borderRadius: 6 // Bo góc cột
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // Ẩn chú thích
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw;
                                    // Định dạng số tiền có dấu chấm phân cách
                                    return value.toLocaleString('vi-VN') + ' VNĐ';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000) + ' Triệu';
                                    } else if (value >= 1000) {
                                        return (value / 1000) + 'k';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>