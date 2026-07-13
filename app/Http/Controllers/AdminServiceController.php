<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    // 1. Hiển thị danh sách dịch vụ
    public function index()
    {
        $services = Service::paginate(10);
        return view('admin.services.index', compact('services'));
    }

    // 2. Form thêm dịch vụ mới
    public function create()
    {
        return view('admin.services.create');
    }

    // 3. Lưu dịch vụ mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.services.index')->with('status', 'Thêm dịch vụ thành công!');
    }

    // 4. Form sửa dịch vụ
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    // 5. Cập nhật dịch vụ
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('admin.services.index')->with('status', 'Cập nhật dịch vụ thành công!');
    }

    // 6. Xóa dịch vụ
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Đã xóa dịch vụ!');
    }
}