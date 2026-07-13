<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    // 1. Hiển thị danh sách khách hàng
    public function index()
    {
        // Lấy danh sách tài khoản, đếm số lượng đơn đặt sân của mỗi người
        $customers = User::withCount('bookings')->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    // 2. Hiển thị form phân quyền (Sửa tài khoản)
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        $roles = Role::all(); // Lấy danh sách vai trò (Admin, Customer)
        
        return view('admin.customers.edit', compact('customer', 'roles'));
    }

    // 3. Xử lý cập nhật quyền
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $customer = User::findOrFail($id);
        
        // Không cho phép Admin tự hạ quyền của chính mình (để tránh mất tài khoản quản trị)
        if ($customer->id === auth()->id() && $request->role_id != $customer->role_id) {
            return back()->withErrors(['role_id' => 'Bạn không thể tự thay đổi quyền của chính mình!']);
        }

        $customer->update(['role_id' => $request->role_id]);

        return redirect()->route('admin.customers.index')->with('status', 'Cập nhật phân quyền tài khoản thành công!');
    }
}