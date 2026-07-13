<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cập nhật: {{ $service->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded-lg shadow">
            <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Tên dịch vụ</label>
                    <input type="text" name="name" value="{{ $service->name }}" class="w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Đơn giá (VNĐ)</label>
                    <input type="number" name="price" value="{{ (int)$service->price }}" class="w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Mô tả thêm</label>
                    <textarea name="description" class="w-full rounded border-gray-300">{{ $service->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Trạng thái</label>
                    <select name="is_active" class="w-full rounded border-gray-300" required>
                        <option value="1" {{ $service->is_active == 1 ? 'selected' : '' }}>Mở bán</option>
                        <option value="0" {{ $service->is_active == 0 ? 'selected' : '' }}>Tạm ngừng</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Hủy</a>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>