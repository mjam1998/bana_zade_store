<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Rules\SlugRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminExtraPageController extends Controller
{
    public function index(){
        return view('admin.extra-page.index');
    }
    public function create(){
        return view('admin.extra-page.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:300',
            'slug' => [
                'required',
                'string',
                'max:300',
                'unique:blogs,slug',
                new SlugRule(),
            ],
            'description' => 'required',
            'meta_title' => 'nullable|string|max:400',
            'meta_description' => 'nullable|string|max:400',
        ], [
            'title.required' => 'وارد کردن عنوان الزامی است.',
            'title.max' => 'طول عنوان نباید بیشتر از ۳۰۰ کاراکتر باشد.',
            'slug.required' => 'وارد کردن اسلاگ الزامی است.',
            'slug.max' => 'طول اسلاگ نباید بیشتر از ۳۰۰ کاراکتر باشد.',
            'slug.unique' => 'این اسلاگ قبلاً استفاده شده است.',
            'meta_description.max' => 'طول توضیحات متا نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'meta_title.max' => 'طول عنوان متا نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'description.required' => 'وارد کردن توضیحات الزامی است.',

        ]);


        Page::create($data);

        return redirect()->route('admin.extra.page.index')->with('success', 'صفحه با موفقیت افزوده شد.');
    }

    public function edit(Page $page){
        return view('admin.extra-page.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|string|max:300',
            'slug' => [
                'required',
                'string',
                'max:300',
                'unique:blogs,slug,' . $page->id,
                new SlugRule(),
            ],
            'description' => 'required',
            'meta_description' => 'nullable|string|max:400',
            'meta_title' => 'nullable|string|max:400',

        ], [
            'title.required' => 'وارد کردن عنوان الزامی است.',
            'title.max' => 'طول عنوان نباید بیشتر از ۳۰۰ کاراکتر باشد.',
            'slug.required' => 'وارد کردن اسلاگ الزامی است.',
            'slug.max' => 'طول اسلاگ نباید بیشتر از ۳۰۰ کاراکتر باشد.',
            'slug.unique' => 'این اسلاگ قبلاً استفاده شده است.',
            'meta_description.max' => 'طول توضیحات متا نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'meta_title.max' => 'طول عنوان متا نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'description.required' => 'وارد کردن توضیحات الزامی است.',
        ]);



        $page->update($data);

        return back()->with('success', 'صفحه با موفقیت ویرایش شد.');
    }
    public function delete(Page $page){
        $page->delete();
        return back()->with('success', 'صفحه با موفقیت حذف شد.');
    }
}
