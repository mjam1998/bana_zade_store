<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SendMethod;
use Illuminate\Http\Request;

class AdminSendMethodController extends Controller
{
    public function index(){
        return view('admin.send-method.index');
    }
    public function create()
    {
        return view('admin.send-method.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'name.required' => 'نام روش ارسال الزامی است.',
            'name.max' => 'نام نباید بیشتر از 255 کاراکتر باشد.',
            'description.required' => 'توضیحات الزامی است.',
        ]);

        SendMethod::create($request->only('name', 'description'));

        return redirect()->route('admin.send-method.index')
            ->with('success', 'روش ارسال با موفقیت ایجاد شد.');
    }

    public function edit(SendMethod $sendMethod)
    {
        return view('admin.send-method.edit', compact('sendMethod'));
    }

    public function update(Request $request, SendMethod $sendMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'name.required' => 'نام روش ارسال الزامی است.',
            'name.max' => 'نام نباید بیشتر از 255 کاراکتر باشد.',
            'description.required' => 'توضیحات الزامی است.',
        ]);

        $sendMethod->update($request->only('name', 'description'));

        return redirect()->route('admin.send-method.index')
            ->with('success', 'روش ارسال با موفقیت ویرایش شد.');
    }

    public function delete(SendMethod $sendMethod){
        $sendMethod->delete();
        return redirect()->route('admin.send-method.index')
            ->with('success', 'روش ارسال با موفقیت حذف شد.');
    }
}
