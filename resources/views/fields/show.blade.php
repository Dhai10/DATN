<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chi tiết Sân bóng') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="w-full h-48 md:h-64 bg-green-800 sm:rounded-xl shadow-md relative overflow-hidden flex items-center justify-center mb-6">
                <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/grass.png')]"></div>
                <span class="text-white text-6xl md:text-8xl opacity-30 z-10">⚽</span>
                
                <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 to-transparent p-6 z-10">
                    <span class="bg-indigo-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                        {{ $field->fieldType->name }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mt-2 drop-shadow-lg">{{ $field->name }}</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <div class="lg:col-span-4 flex flex-col gap-6">
                    
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl shadow-sm border border-blue-100">
                        <div class="text-center mb-6">
                            <span class="text-sm text-gray-500 font-medium block mb-1">Mức giá thuê cố định</span>
                            <div class="flex items-baseline justify-center">
                                <span class="text-4xl font-extrabold text-red-600">{{ number_format($field->price_per_hour, 0, ',', '.') }}</span>
                                <span class="text-lg text-gray-500 ml-1 font-medium">đ / giờ</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('bookings.create', $field->id) }}" class="flex items-center justify-center w-full py-3 px-4 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Bấm để Đặt sân
                        </a>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4">Thông tin chung</h3>
                        
                        <p class="text-gray-600 leading-relaxed text-sm mb-5">
                            Trải nghiệm mặt cỏ nhân tạo chất lượng cao, hệ thống dàn đèn LED chuẩn thi đấu ban đêm. Sân bóng luôn được vệ sinh sạch sẽ, có khu vực nghỉ ngơi và tủ đồ an toàn cho các đội viên.
                        </p>

                        <ul class="space-y-4 text-sm text-gray-700">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <span class="block font-bold text-gray-900">Giờ hoạt động</span>
                                    <span class="text-gray-500">06:00 sáng - 23:00 đêm</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <div>
                                    <span class="block font-bold text-gray-900">Vị trí</span>
                                    <span class="text-gray-500">Cụm sân cỏ nhân tạo, Khu A</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-full">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-2">
                            <h3 class="text-xl font-bold text-gray-900">Xem lịch trống tuần này</h3>
                            
                            <div class="flex items-center gap-4 text-sm font-medium text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                                <div class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full mr-2 shadow-sm"></span> Đã kín</div>
                                <div class="flex items-center"><span class="w-3 h-3 bg-white border border-gray-400 rounded-full mr-2"></span> Đang trống</div>
                            </div>
                        </div>
                        
                        <div id="calendar" class="min-h-[600px]"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek', 
                locale: 'vi', 
                height: 'auto', // Tự động kéo dãn chiều cao theo cột lưới
                expandRows: true, // Chia đều khoảng cách các hàng giờ
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hôm nay',
                    month: 'Tháng',
                    week: 'Tuần',
                    day: 'Ngày'
                },
                slotMinTime: '06:00:00', 
                slotMaxTime: '23:00:00', 
                allDaySlot: false, 
                events: "{{ route('fields.bookings.json', $field->id) }}",
            });
            
            calendar.render();
        });
    </script>
</x-app-layout>