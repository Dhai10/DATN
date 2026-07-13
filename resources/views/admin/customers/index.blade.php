<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Khách hàng') }}
        </h2>
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
                            <th class="px-6 py-3">Tên Khách hàng</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Vai trò</th>
                            <th class="px-6 py-3">Tổng số đơn đặt</th>
                            <th class="px-6 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold">{{ $customer->id }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $customer->name }}</td>
                                <td class="px-6 py-4">{{ $customer->email }}</td>
                                <td class="px-6 py-4">
                                    @if($customer->role_id == 1)
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-bold">Admin</span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Khách hàng</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-bold text-green-600">{{ $customer->bookings_count }} đơn</td>
                                <td class="px-6 py-4 flex justify-center gap-2">
                                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="text-white bg-indigo-500 hover:bg-indigo-600 px-3 py-1 rounded">Phân quyền</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $customers->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>