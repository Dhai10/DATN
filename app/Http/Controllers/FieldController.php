<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::all();
        return view('admin.fields', compact('fields'));
    }

    public function create()
    {
        return view('admin.fields-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price_per_hour' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('fields', 'public');
            $data['image'] = $imagePath;
        }

        Field::create($data);

        return redirect()->route('admin.fields')->with('success', 'Sân bóng đã được tạo thành công!');
    }

    public function edit(Field $field)
    {
        return view('admin.fields-edit', compact('field'));
    }

    public function update(Request $request, Field $field)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price_per_hour' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('fields', 'public');
            $data['image'] = $imagePath;
        }

        $field->update($data);

        return redirect()->route('admin.fields')->with('success', 'Sân bóng đã được cập nhật!');
    }

    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('admin.fields')->with('success', 'Sân bóng đã được xóa!');
    }
}
