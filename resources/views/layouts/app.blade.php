<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PolyPitch') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                
                // 1. Popup Thông báo Thành công (Màu xanh)
                @if (session('status'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: '{{ session('status') }}',
                        showConfirmButton: false,
                        timer: 2500, // Tự động đóng sau 2.5 giây
                        backdrop: `rgba(0,0,123,0.1)` 
                    });
                @endif

                // 2. Popup Thông báo Lỗi riêng lẻ (Màu đỏ)
                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Rất tiếc...',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#ef4444', 
                    });
                @endif

                // 3. Popup Thông báo Lỗi Form / Validation (Màu vàng cảnh báo)
                @if ($errors->any())
                    Swal.fire({
                        icon: 'warning',
                        title: 'Vui lòng kiểm tra lại!',
                        html: `
                            <ul class="text-left text-sm text-red-500 space-y-1 mt-2 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        `,
                        confirmButtonColor: '#3b82f6', 
                    });
                @endif

            });
        </script>
    </body>
</html>