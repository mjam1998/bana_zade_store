<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Rules\SlugRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class AdminBlogController extends Controller
{
    public function index(){
        return view('admin.blog.index');
    }
    public function create()
    {
        return view('admin.blog.create');
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
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5148',
            'image_alt' => 'nullable|string|max:400',
            'image_title' => 'nullable|string|max:400',
            'meta_description' => 'nullable|string|max:400',
            'meta_title' => 'nullable|string|max:400',
            'keywords' => 'nullable|string|max:400',
        ], [
            'title.required' => 'وارد کردن عنوان الزامی است.',
            'image.required' => 'وارد کردن عکس الزامی است.',
            'title.max' => 'طول عنوان نباید بیشتر از ۳۰۰ کاراکتر باشد.',
            'keywords.max' => 'کلمات کلیدی نباید بیشتر از 400 کاراکتر باشد',
            'slug.required' => 'وارد کردن اسلاگ الزامی است.',
            'slug.max' => 'طول اسلاگ نباید بیشتر از ۳۰۰ کاراکتر باشد.',
            'slug.unique' => 'این اسلاگ قبلاً استفاده شده است.',

            'description.required' => 'وارد کردن توضیحات الزامی است.',

            'image.image' => 'فایل انتخابی باید تصویر باشد.',
            'image.mimes' => 'فرمت تصویر باید jpeg، png، jpg یا webp باشد.',
            'image.max' => 'حجم تصویر نباید بیشتر از 5 مگابایت باشد.',

            'image_alt.max' => 'طول متن جایگزین تصویر نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'image_title.max' => 'طول عنوان تصویر نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'meta_description.max' => 'طول توضیحات متا نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'meta_title.max' => 'طول عنوان متا نباید بیشتر از ۴۰۰ کاراکتر باشد.',
        ]);

        if ($request->hasFile('image')) {

            $filename = $data['slug'] . "_" . time() . ".webp";

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image'));
            $encoded = $image->encode(new WebpEncoder(quality: 80));

            Storage::disk('public')->put('blog/' . $filename, (string) $encoded);
            $data['image'] = $filename;
        }

        Blog::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'بلاگ با موفقیت افزوده شد.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title' => 'required|string|max:300',
            'slug' => [
                'required',
                'string',
                'max:300',
                'unique:blogs,slug,' . $blog->id,
                new SlugRule(),
            ],
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5148',
            'image_alt' => 'nullable|string|max:400',
            'image_title' => 'nullable|string|max:400',
            'meta_description' => 'nullable|string|max:400',
            'meta_title' => 'nullable|string|max:400',
            'keywords' => 'nullable|string|max:400',
        ], [
            'title.required' => 'وارد کردن عنوان الزامی است.',
            'title.max' => 'طول عنوان نباید بیشتر از ۳۰۰ کاراکتر باشد.',
            'keywords.max' => 'کلمات کلیدی نباید بیشتر از 400 کاراکتر باشد',
            'slug.required' => 'وارد کردن اسلاگ الزامی است.',
            'slug.max' => 'طول اسلاگ نباید بیشتر از ۳۰۰ کاراکتر باشد.',
            'slug.unique' => 'این اسلاگ قبلاً استفاده شده است.',

            'description.required' => 'وارد کردن توضیحات الزامی است.',

            'image.image' => 'فایل انتخابی باید تصویر باشد.',
            'image.mimes' => 'فرمت تصویر باید jpeg، png، jpg یا webp باشد.',
            'image.max' => 'حجم تصویر نباید بیشتر از 5 مگابایت باشد.',

            'image_alt.max' => 'طول متن جایگزین تصویر نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'image_title.max' => 'طول عنوان تصویر نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'meta_description.max' => 'طول توضیحات متا نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'meta_title.max' => 'طول عنوان متا نباید بیشتر از ۴۰۰ کاراکتر باشد.',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete('blog/' . $blog->image);
            }

            $filename = $data['slug'] . "_" . time() . ".webp";

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image'));
            $encoded = $image->encode(new WebpEncoder(quality: 80));
            Storage::disk('public')->put('blog/' . $filename, (string) $encoded);
            $data['image'] = $filename;
        } else {
            unset($data['image']);
        }

        $blog->update($data);

        return back()->with('success', 'بلاگ با موفقیت ویرایش شد.');
    }

    public function delete(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete('blog/' . $blog->image);
        }

        $blog->delete();

        return back()->with('success', 'بلاگ با موفقیت حذف شد.');
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4048'
        ]);

        if ($request->hasFile('file')) {

            $filename = time() . ".webp";

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('file'));
            $encoded = $image->encode(new WebpEncoder(quality: 80));
           Storage::disk('public')->put('images/' . $filename, (string) $encoded);

            return response()->json([
                'location' => asset( 'images/' . $filename ),
            ]);
        }

        return response()->json(['error' => 'خطا در آپلود تصویر'], 400);
    }

}
