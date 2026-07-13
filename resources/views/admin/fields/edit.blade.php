<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cập nhật sân bóng: {{ $field->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded-lg shadow">
            <form action="{{ route('admin.fields.update', $field->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Tên sân</label>
                    <input type="text" name="name" value="{{ $field->name }}" class="w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Loại sân</label>
                    <select name="field_type_id" class="w-full rounded border-gray-300" required>
                        @foreach($fieldTypes as $type)
                            <option value="{{ $type->id }}" {{ $field->field_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Giá mỗi giờ (VNĐ)</label>
                    <input type="number" name="price_per_hour" value="{{ (int)$field->price_per_hour }}" class="w-full rounded border-gray-300" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Trạng thái</label>
                    <select name="is_active" class="w-full rounded border-gray-300" required>
                        <option value="1" {{ $field->is_active == 1 ? 'selected' : '' }}>Đang mở bán</option>
                        <option value="0" {{ $field->is_active == 0 ? 'selected' : '' }}>Tạm đóng cửa / Bảo trì</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.fields.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Hủy</a>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>