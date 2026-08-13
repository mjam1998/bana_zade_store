<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BannerType;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\VideoBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banner = VideoBanner::query()->latest()->first();
        return view('admin.banner.index', compact('banner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'video_mp4' => 'nullable|mimes:mp4|max:20480',
            'video_webm' => 'nullable|mimes:webm|max:20480',
            'image' => 'nullable|image',
            'image_alt' => 'nullable|string|max:255',
            'page_title' => 'required|string|max:255',
            'meta_description' => 'nullable|string',
        ], [
            'video_mp4.mimes' => 'فایل ویدئویی باید با فرمت MP4 باشد.',
            'video_mp4.max' => 'حجم ویدئوی MP4 نباید بیشتر از ۲۰ مگابایت باشد.',

            'video_webm.mimes' => 'فایل ویدئویی باید با فرمت WebM باشد.',
            'video_webm.max' => 'حجم ویدئوی WebM نباید بیشتر از ۲۰ مگابایت باشد.',

            'image.image' => 'فایل انتخاب‌شده باید یک تصویر معتبر باشد.',

            'image_alt.string' => 'متن جایگزین تصویر باید به صورت متن باشد.',
            'image_alt.max' => 'متن جایگزین تصویر نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'page_title.required' => 'وارد کردن عنوان صفحه الزامی است.',
            'page_title.string' => 'عنوان صفحه باید به صورت متن باشد.',
            'page_title.max' => 'عنوان صفحه نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'meta_description.string' => 'توضیحات متا باید به صورت متن باشد.',
        ]);

        $banner = VideoBanner::firstOrNew([]);

        // پردازش تصویر به WebP
        if ($request->hasFile('image')) {
            if ($banner->image) Storage::disk('public')->delete('banners/' . $banner->image);

            $filename = time() . ".webp";

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image'));
            $encoded = $image->encode(new WebpEncoder(quality: 80));
            Storage::disk('public')->put('banners/' . $filename, (string) $encoded);

            $banner->image = $filename;
        }

        // آپلود ویدیو MP4
        if ($request->hasFile('video_mp4')) {

            // حذف ویدیوی قبلی
            if ($banner->video_mp4) {
                Storage::disk('public')->delete('banners/' . $banner->video_mp4);
            }

            // ذخیره فایل
            $filename = $request->file('video_mp4')->hashName();

            $request->file('video_mp4')->storeAs(
                'banners',
                $filename,
                'public'
            );

            // فقط نام فایل در دیتابیس
            $banner->video_mp4 = $filename;
        }



        if ($request->hasFile('video_webm')) {


            if ($banner->video_webm) {
                Storage::disk('public')->delete('banners/' . $banner->video_webm);
            }


            $filename = $request->file('video_webm')->hashName();

            $request->file('video_webm')->storeAs(
                'banners',
                $filename,
                'public'
            );


            $banner->video_webm = $filename;
        }

        $banner->image_alt = $request->image_alt;
        $banner->page_title = $request->page_title;
        $banner->meta_description = $request->meta_description;
        $banner->save();

        return back()->with('success', 'بنر و متا تگ‌ها با موفقیت ذخیره شدند.');
    }

    public function destroy(VideoBanner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete('banners/'.$banner->image);
        }
        if ($banner->video_mp4) {
            Storage::disk('public')->delete('banners/' . $banner->video_mp4);
        }
        if ($banner->video_mp4) {
            Storage::disk('public')->delete('banners/' . $banner->video_mp4);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'بنر با موفقیت حذف شد');
    }
}
