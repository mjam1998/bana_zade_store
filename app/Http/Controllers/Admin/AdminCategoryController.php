<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MegaCategory;
use App\Models\SuperCategory;
use App\Rules\SlugRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function megaCategoryIndex(){
        return view('admin.category.mega-category.index');
    }
    public function megaCategoryCreate(){
        return view('admin.category.mega-category.create');
    }
    public function megaCategoryStore(Request $request){
       $data= $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.string'   => 'نام باید به صور متن وارد شود.',
            'name.max'      => 'نام نباید بیشتر از ۲۵۵ کاراکتر باشد.',
        ]);
        MegaCategory::create($data);
        return redirect()->route('admin.mega-category.index')->with('success','دسته بندی با موفقیت افزوده شد.');

    }
    public function megaCategoryEdit(MegaCategory $megaCategory)
    {
        return view('admin.category.mega-category.edit', compact('megaCategory'));
    }
    public function megaCategoryUpdate(Request $request, MegaCategory $megaCategory){
        $data= $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.string'   => 'نام باید به صور متن وارد شود.',
            'name.max'      => 'نام نباید بیشتر از ۲۵۵ کاراکتر باشد.',
        ]);
        $megaCategory->update($data);
        return redirect()->route('admin.mega-category.index')->with('success','دسته بندی با موفقیت ویرایش شد.');
    }
    public function megaCategoryDelete(MegaCategory $megaCategory)
    {
        $megaCategory->delete();
        return redirect()->route('admin.mega-category.index')->with('success','دسته بندی با موفقیت حذف شد.');
    }
    public function superCategoryIndex(MegaCategory $megaCategory){
        return view('admin.category.super-category.index', compact('megaCategory'));
    }
    public function superCategoryCreate(MegaCategory $megaCategory){
        return view('admin.category.super-category.create', compact('megaCategory'));
    }
    public function superCategoryStore(Request $request){
        $data= $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mega_category_id' => ['required', 'exists:mega_categories,id'],
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'mega_category_id.required' => 'وارد کردن دسته بندی شاخه اول الزامی است.',
            'mega_category_id.exists' => 'ایدی دسته بندی شاخه اول نامعتبر است.',
            'name.string'   => 'نام باید به صور متن وارد شود.',
            'name.max'      => 'نام نباید بیشتر از ۲۵۵ کاراکتر باشد.',
        ]);
        SuperCategory::create($data);
        return redirect()->route('admin.super-category.index',['mega_category'=>$data['mega_category_id']])->with('success','دسته بندی با موفقیت افزوده شد.');
    }
    public function superCategoryEdit(SuperCategory $superCategory){
        return view('admin.category.super-category.edit', compact('superCategory'));
    }
    public function superCategoryUpdate(Request $request, SuperCategory $superCategory){
        $data= $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mega_category_id' => ['required', 'exists:mega_categories,id'],
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'mega_category_id.required' => 'وارد کردن دسته بندی شاخه اول الزامی است.',
            'mega_category_id.exists' => 'ایدی دسته بندی شاخه اول نامعتبر است.',
            'name.string'   => 'نام باید به صور متن وارد شود.',
            'name.max'      => 'نام نباید بیشتر از ۲۵۵ کاراکتر باشد.',
        ]);
        $superCategory->update($data);
        return redirect()->route('admin.super-category.index',['mega_category'=>$data['mega_category_id']])->with('success','دسته بندی با موفقیت ویرایش شد.');
    }
    public function superCategoryDelete(SuperCategory $superCategory){
        $superCategory->delete();
        return back()->with('success','دسته بندی با موفقیت حذف شد.');
    }
    public function primaryCategoryIndex(SuperCategory $superCategory)
    {
        return view('admin.category.primary-category.index', compact('superCategory'));
    }
    public function primaryCategoryCreate(SuperCategory $superCategory){
        return view('admin.category.primary-category.create', compact('superCategory'));
    }
    public function primaryCategoryStore(Request $request)
    {
        $data = $request->validate([
            'super_category_id' => 'required|exists:super_categories,id',
            'name' => 'required|string|max:300',
            'slug' => [
                'required',
                'string',
                'max:300',
                'unique:categories,slug,',
                new SlugRule(),
            ],
            'is_list'=> 'nullable|boolean',
            'meta_title' => 'nullable|string|max:300',
            'meta_description' => 'nullable|string|max:300',
            'keywords' => 'nullable|string|max:400',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5148',
            'image_alt' => 'nullable|string|max:400',
            'image_title' => 'nullable|string|max:400',
        ], [
            'super_category_id.required' => 'انتخاب دسته‌بندی اصلی الزامی است',
            'super_category_id.exists' => 'دسته‌بندی اصلی انتخاب شده معتبر نیست',
            'name.required' => 'نام دسته‌بندی الزامی است',
            'name.max' => 'نام دسته‌بندی نباید بیشتر از 300 کاراکتر باشد',
            'slug.required' => 'اسلاگ الزامی است',
            'slug.max' => 'اسلاگ نباید بیشتر از 300 کاراکتر باشد',
            'slug.unique' => 'این اسلاگ قبلا استفاده شده است',
            'meta_title.max' => 'عنوان متا صفحه نباید بیشتر از 300 کاراکتر باشد',
            'meta_description.max' => 'توضیحات متا نباید بیشتر از 300 کاراکتر باشد',
            'keywords.max' => 'کلمات کلیدی نباید بیشتر از 400 کاراکتر باشد',
            'image.required' => 'تصویر دسته‌بندی الزامی است',
            'image.image' => 'فایل انتخابی باید تصویر باشد',
            'image.mimes' => 'فرمت تصویر باید jpeg، png، jpg یا webp باشد',
            'image.max' => 'حجم تصویر نباید بیشتر از 5 مگابایت باشد',
            'image_alt.max' => 'Alt تصویر نباید بیشتر از 400 کاراکتر باشد',
            'image_title.max' => 'Title تصویر نباید بیشتر از 400 کاراکتر باشد',
        ]);
        $file = $request->file("image");
        $ext = $file->getClientOriginalExtension();
        $filename =  $data['slug']."_" .time(). "." . $ext;
        $file->storeAs('category', $filename, 'public');
        $data['image'] = $filename;
        Category::create($data);
        return redirect()->route('admin.primary-category.index',['super_category'=>$data['super_category_id']])->with('success','دسته بندی با موفقیت افزوده شد.');

    }
    public function primaryCategoryEdit(Category $category){
        return view('admin.category.primary-category.edit', compact('category'));
    }
    public function primaryCategoryUpdate(Request $request, Category $category){
        $data = $request->validate([
            'super_category_id' => 'required|exists:super_categories,id',
            'name' => 'required|string|max:300',
            'slug' => [
                'required',
                'string',
                'max:300',
                'unique:categories,slug,' . $category->id,
                new SlugRule(),
            ],
            'is_list'=> 'nullable|boolean',
            'meta_title' => 'nullable|string|max:300',
            'meta_description' => 'nullable|string|max:300',
            'keywords' => 'nullable|string|max:400',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5148',
            'image_alt' => 'nullable|string|max:400',
            'image_title' => 'nullable|string|max:400',
        ], [
            'super_category_id.required' => 'انتخاب دسته‌بندی اصلی الزامی است',
            'super_category_id.exists' => 'دسته‌بندی اصلی انتخاب شده معتبر نیست',
            'name.required' => 'نام دسته‌بندی الزامی است',
            'name.max' => 'نام دسته‌بندی نباید بیشتر از 300 کاراکتر باشد',
            'slug.required' => 'اسلاگ الزامی است',
            'slug.max' => 'اسلاگ نباید بیشتر از 300 کاراکتر باشد',
            'slug.unique' => 'این اسلاگ قبلا استفاده شده است',
            'meta_title.max' => 'عنوان متا صفحه نباید بیشتر از 300 کاراکتر باشد',
            'meta_description.max' => 'توضیحات متا نباید بیشتر از 300 کاراکتر باشد',
            'keywords.max' => 'کلمات کلیدی نباید بیشتر از 400 کاراکتر باشد',
            'image.image' => 'فایل انتخابی باید تصویر باشد',
            'image.mimes' => 'فرمت تصویر باید jpeg، png، jpg یا webp باشد',
            'image.max' => 'حجم تصویر نباید بیشتر از 5 مگابایت باشد',
            'image_alt.max' => 'Alt تصویر نباید بیشتر از 400 کاراکتر باشد',
            'image_title.max' => 'Title تصویر نباید بیشتر از 400 کاراکتر باشد',
        ]);
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            if ($category->image) {
                Storage::disk('public')->delete('category/' . $category->image);
            }
            $ext = $file->getClientOriginalExtension();
            $filename =  $data['slug']."_" .time(). "." . $ext;
            $file->storeAs('category', $filename, 'public');
            $data['image'] = $filename;
        }
        $category->update($data);
        return redirect()->route('admin.primary-category.index',['super_category'=>$data['super_category_id']])->with('success','دسته بندی با موفقیت ویرایش شد.');

    }
    public function primaryCategoryDelete(Category $category){
        $category->delete();
        return back()->with('success','دسته بندی با موفقیت حذف شد.');

    }
    public function categoryProductIndex(Category $category)
    {
        return view('admin.category.product.index', compact('category'));
    }
}
