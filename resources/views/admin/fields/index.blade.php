<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Sân bóng') }}
            </h2>
            <a href="{{ route('admin.fields.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Thêm sân mới
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Tên sân</th>
                            <th class="px-6 py-3">Loại sân</th>
                            <th class="px-6 py-3">Giá / Giờ</th>
                            <th class="px-6 py-3">Trạng thái</th>
                            <th class="px-6 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fields as $field)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $field->id }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $field->name }}</td>
                                <td class="px-6 py-4">{{ $field->fieldType->name }}</td>
                                <td class="px-6 py-4 text-red-500 font-bold">{{ number_format($field->price_per_hour, 0, ',', '.') }} đ</td>
                                <td class="px-6 py-4">
                                    @if($field->is_active)
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Đang mở</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Đang bảo trì</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-2">
                                    <a href="{{ route('admin.fields.edit', $field->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded">Sửa</a>
                                    <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Xóa sân này sẽ xóa cả lịch sử đặt sân của nó. Bạn có chắc chắn?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $fields->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>