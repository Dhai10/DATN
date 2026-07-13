<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Thêm Dịch vụ mới</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded-lg shadow">
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Tên dịch vụ</label>
                    <input type="text" name="name" class="w-full rounded border-gray-300" placeholder="VD: Nước suối, Thuê áo..." required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Đơn giá (VNĐ)</label>
                    <input type="number" name="price" class="w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Mô tả thêm (Tùy chọn)</label>
                    <textarea name="description" class="w-full rounded border-gray-300"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Trạng thái</label>
                    <select name="is_active" class="w-full rounded border-gray-300" required>
                        <option value="1">Mở bán</option>
                        <option value="0">Tạm ngừng</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Hủy</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu thông tin</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>