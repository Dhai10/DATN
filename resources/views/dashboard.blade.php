<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Danh sách Sân bóng') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-700">Tìm kiếm sân nhanh</h3>
                
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-3">
                    <label for="type" class="text-sm text-gray-600">Loại sân:</label>
                    <select name="type" id="type" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" onchange="this.form.submit()">
                        <option value="">-- Tất cả --</option>
                        @foreach($fieldTypes as $type)
                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    @if(request()->has('type') && request('type') != '')
                        <a href="{{ route('dashboard') }}" class="text-sm text-red-500 hover:text-red-700 underline">Xóa lọc</a>
                    @endif
                </form>
            </div>

            <!-- Grid hiển thị các sân -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($fields as $field)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <!-- Ảnh minh họa (tạm thời dùng màu xám) -->
                        <div class="h-40 bg-green-600 flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">⚽</span>
                        </div>
                        
                        <!-- Thông tin sân -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ $field->name }}</h3>
                            <p class="text-gray-600 mt-1">Loại sân: <span class="font-semibold">{{ $field->fieldType->name }}</span></p>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-red-500 font-bold text-lg">
                                    {{ number_format($field->price_per_hour, 0, ',', '.') }} VNĐ / giờ
                                </span>
                                
                                <a href="{{ route('fields.show', $field->id) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition inline-block text-center w-full sm:w-auto">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>