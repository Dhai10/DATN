<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Dịch vụ') }}
            </h2>
            <a href="{{ route('admin.services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Thêm dịch vụ
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
                            <th class="px-6 py-3">Tên Dịch vụ</th>
                            <th class="px-6 py-3">Đơn giá</th>
                            <th class="px-6 py-3">Trạng thái</th>
                            <th class="px-6 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $item->id }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-red-500 font-bold">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                <td class="px-6 py-4">
                                    @if($item->is_active)
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Đang bán</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Ngừng bán</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-2">
                                    <a href="{{ route('admin.services.edit', $item->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded">Sửa</a>
                                    <form action="{{ route('admin.services.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $services->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>