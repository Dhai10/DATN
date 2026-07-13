<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldType;
use Illuminate\Http\Request;

class AdminFieldController extends Controller
{
    // 1. Hiển thị danh sách sân bóng
    public function index()
    {
        $fields = Field::with('fieldType')->paginate(10);
        return view('admin.fields.index', compact('fields'));
    }

    // 2. Hiển thị form Thêm sân mới
    public function create()
    {
        $fieldTypes = FieldType::all(); // Lấy danh sách loại sân để chọn
        return view('admin.fields.create', compact('fieldTypes'));
    }

    // 3. Xử lý lưu sân mới vào DB
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'field_type_id' => 'required|exists:field_types,id',
            'price_per_hour' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        Field::create($request->all());

        return redirect()->route('admin.fields.index')->with('status', 'Thêm sân bóng thành công!');
    }

    // 4. Hiển thị form Sửa sân
    public function edit($id)
    {
        $field = Field::findOrFail($id);
        $fieldTypes = FieldType::all();
        return view('admin.fields.edit', compact('field', 'fieldTypes'));
    }

    // 5. Xử lý cập nhật thông tin sân
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'field_type_id' => 'required|exists:field_types,id',
            'price_per_hour' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $field = Field::findOrFail($id);
        $field->update($request->all());

        return redirect()->route('admin.fields.index')->with('status', 'Cập nhật thông tin sân thành công!');
    }

    // 6. Xử lý Xóa sân
    public function destroy($id)
    {
        $field = Field::findOrFail($id);
        $field->delete();

        return redirect()->route('admin.fields.index')->with('status', 'Xóa sân bóng thành công!');
    }
}