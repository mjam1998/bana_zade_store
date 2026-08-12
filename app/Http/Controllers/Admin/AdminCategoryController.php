<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\SlugRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class AdminCategoryController extends Controller
{

    public function index()
    {
        return view('admin.category.index');
    }
    public function create(){
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([

            'name' => 'required|string|max:300',
            'slug' => [
                'required',
                'string',
                'max:300',
                'unique:categories,slug,',
                new SlugRule(),
            ],

            'meta_title' => 'nullable|string|max:300',
            'meta_description' => 'nullable|string|max:300',
            'keywords' => 'nullable|string|max:400',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,jfif|max:5148',
            'image_alt' => 'nullable|string|max:400',
            'image_title' => 'nullable|string|max:400',
        ], [
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
            'image.mimes' => 'فرمت تصویر باید jpeg،jfif، png، jpg یا webp باشد',
            'image.max' => 'حجم تصویر نباید بیشتر از 5 مگابایت باشد',
            'image_alt.max' => 'Alt تصویر نباید بیشتر از 400 کاراکتر باشد',
            'image_title.max' => 'Title تصویر نباید بیشتر از 400 کاراکتر باشد',
        ]);

        $filename = $data['slug'] . "_" . time() . ".webp";

        $manager = new ImageManager(new Driver());
        $image = $manager->decode($request->file('image'));
        $encoded = $image->encode(new WebpEncoder(quality: 80));

        Storage::disk('public')->put('category/' . $filename, (string) $encoded);

        $data['image'] = $filename;
        Category::create($data);
        return redirect()->route('admin.category.index')->with('success','دسته بندی با موفقیت افزوده شد.');

    }
    public function edit(Category $category){
        return view('admin.category.edit', compact('category'));
    }
    public function update(Request $request, Category $category){
        $data = $request->validate([

            'name' => 'required|string|max:300',
            'slug' => [
                'required',
                'string',
                'max:300',
                'unique:categories,slug,' . $category->id,
                new SlugRule(),
            ],
            'meta_title' => 'nullable|string|max:300',
            'meta_description' => 'nullable|string|max:300',
            'keywords' => 'nullable|string|max:400',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,jfif,webp|max:5148',
            'image_alt' => 'nullable|string|max:400',
            'image_title' => 'nullable|string|max:400',
        ], [
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
            if ($category->image) {
                Storage::disk('public')->delete('category/' . $category->image);
            }
            $filename = $data['slug'] . "_" . time() . ".webp";

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image'));
            $encoded = $image->encode(new WebpEncoder(quality: 80));

            Storage::disk('public')->put('category/' . $filename, (string) $encoded);
            $data['image'] = $filename;
        }
        $category->update($data);
        return redirect()->route('admin.category.index')->with('success','دسته بندی با موفقیت ویرایش شد.');

    }
    public function delete(Category $category){
        $category->delete();
        return back()->with('success','دسته بندی با موفقیت حذف شد.');

    }

    public function changeStatus(Category $category)
    {
       if ($category->is_active){
           $category->update(['is_active' => false]);
       }else{
           $category->update(['is_active' => true]);
       }
        return back()->with('success','وضعیت دسته بندی با موفقیت تغییر کرد.');
    }
    public function categoryProductIndex(Category $category)
    {
        return view('admin.category.product.index', compact('category'));
    }
}
