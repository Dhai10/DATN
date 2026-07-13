<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hệ thống Đặt sân Thể thao Hiện đại</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-gray-900 bg-gray-50">

    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="/" class="-m-1.5 p-1.5 flex items-center gap-2">
                    <span class="text-3xl">⚽</span>
                    <span class="font-black text-xl text-white tracking-wider uppercase drop-shadow-md">PolyPitch</span>
                </a>
            </div>
            <div class="flex flex-1 justify-end gap-x-6 items-center">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold leading-6 text-white hover:text-green-400 transition drop-shadow-md">Vào hệ thống <span aria-hidden="true">&rarr;</span></a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold leading-6 text-white hover:text-green-400 transition drop-shadow-md">Đăng nhập</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 transition border border-transparent">Đăng ký ngay</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main>
        <div class="relative isolate overflow-hidden bg-gray-900 pb-16 pt-14 sm:pb-20">
            <img src="https://images.unsplash.com/photo-1529900251209-f1a6ce4e85d4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Sân bóng" class="absolute inset-0 -z-10 h-full w-full object-cover opacity-30">
            
            <div class="mx-auto max-w-7xl px-6 lg:px-8 mt-20">
                <div class="mx-auto max-w-2xl text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-6xl">
                        Nâng Tầm Đam Mê<br><span class="text-green-400">Trải Nghiệm Đỉnh Cao</span>
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-300">
                        Hệ thống đặt sân bóng tự động nhanh chóng, minh bạch. Mặt cỏ nhân tạo chất lượng hàng đầu tại Đà Nẵng, hệ thống chiếu sáng tiêu chuẩn. Đặt sân chỉ với 3 cú click chuột!
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('register') }}" class="rounded-md bg-green-600 px-6 py-3 text-lg font-semibold text-white shadow-sm hover:bg-green-500 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                            Bắt đầu ngay
                        </a>
                        <a href="#featured" class="text-sm font-semibold leading-6 text-white hover:text-gray-300 transition">
                            Xem sân bóng <span aria-hidden="true">↓</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-24 sm:py-32 bg-white">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-green-600 uppercase tracking-wide">Tại sao chọn chúng tôi?</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Hệ thống tiện ích trọn gói</p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                        <div class="flex flex-col bg-gray-50 p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <dt class="flex items-center gap-x-3 text-lg font-bold leading-7 text-gray-900">
                                <span class="text-3xl">⏱️</span> Đặt lịch 24/7 trực tuyến
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Xem lịch trống thực tế theo từng giờ. Không cần gọi điện chờ đợi, chốt sân tức thì bất kể ngày đêm.</p>
                            </dd>
                        </div>
                        <div class="flex flex-col bg-gray-50 p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <dt class="flex items-center gap-x-3 text-lg font-bold leading-7 text-gray-900">
                                <span class="text-3xl">👕</span> Dịch vụ đi kèm đa dạng
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Hỗ trợ thuê áo Bib, bóng thi đấu tiêu chuẩn và các loại nước giải khát ngay trong lúc chọn giờ đá.</p>
                            </dd>
                        </div>
                        <div class="flex flex-col bg-gray-50 p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <dt class="flex items-center gap-x-3 text-lg font-bold leading-7 text-gray-900">
                                <span class="text-3xl">💳</span> Quản lý chi tiêu dễ dàng
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Theo dõi lịch sử đặt sân, hóa đơn chi tiết minh bạch. Hỗ trợ hủy sân tự động khi có thay đổi kế hoạch.</p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div id="featured" class="bg-gray-100 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center mb-16">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Sân bóng nổi bật</h2>
                    <p class="mt-4 text-lg text-gray-600">Lựa chọn những mặt sân tốt nhất cho trận đấu của bạn</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($featuredFields as $field)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="h-48 bg-green-700 flex items-center justify-center relative">
                            <span class="text-5xl text-white opacity-40">⚽</span>
                            <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">HOT</div>
                        </div>
                        <div class="p-6">
                            <div class="text-xs font-bold text-indigo-600 uppercase tracking-wide mb-1">{{ $field->fieldType->name }}</div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $field->name }}</h3>
                            <div class="flex items-center justify-between mt-4 border-t pt-4">
                                <span class="text-red-600 font-extrabold text-lg">{{ number_format($field->price_per_hour, 0, ',', '.') }}đ<span class="text-sm text-gray-500 font-normal">/giờ</span></span>
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Đặt ngay &rarr;</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 py-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} PolyPitch System. Designed & Developed for Frontend Excellence.
            </p>
        </div>
    </footer>

</body>
</html>