<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BannerType;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('type')->get()->groupBy(function($banner) {
            return $banner->type->value;
        });
        return view('admin.banner.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:banners,id',
            'type' => 'required|integer|in:1,2,3,4,5,6',
            'meta_title' => 'nullable|string|max:400',
            'meta_description' => 'nullable|string|max:400',
            'image' => $request->id ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480' : 'required|image|mimes:jpeg,png,jpg,webp|max:20480',
            'image_alt' => 'nullable|string|max:400',
            'image_title' => 'nullable|string|max:400',
            'url' => 'nullable|url|max:500',
        ], [
            'type.required' => 'انتخاب نوع بنر الزامی است.',
            'type.in' => 'نوع بنر انتخاب شده معتبر نیست.',
            'image.required' => 'آپلود تصویر الزامی است.',
            'image.image' => 'فایل آپلود شده باید تصویر باشد.',
            'image.mimes' => 'فرمت تصویر باید jpeg، png، jpg یا webp باشد.',
            'image.max' => 'حجم تصویر نباید بیشتر از 20 مگابایت باشد.',
            'url.url' => 'آدرس URL وارد شده معتبر نیست.',
            'meta_title.max' => 'عنوان متا نباید بیشتر از 400 کاراکتر باشد.',
            'meta_description.max' => 'توضیحات متا نباید بیشتر از 400 کاراکتر باشد.',
        ]);

        // بررسی محدودیت تعداد اسلایدر
        if ($validated['type'] == BannerType::Slider->value) {
            $sliderCount = Banner::where('type', BannerType::Slider->value)
                ->when($request->id, fn($q) => $q->where('id', '!=', $request->id))
                ->count();

            if ($sliderCount >= 5) {
                return back()->withErrors(['type' => 'حداکثر 5 اسلایدر مجاز است'])->withInput();
            }
        }

        // بررسی یکتا بودن سایر بنرها
        if ($validated['type'] != BannerType::Slider->value) {
            $exists = Banner::where('type', $validated['type'])
                ->when($request->id, fn($q) => $q->where('id', '!=', $request->id))
                ->exists();

            if ($exists) {
                return back()->withErrors(['type' => 'این نوع بنر قبلاً ایجاد شده است'])->withInput();
            }
        }

        $banner = $request->id ? Banner::findOrFail($request->id) : new Banner();

        if ($request->hasFile('image')) {
            if ($banner->exists && $banner->image) {
                Storage::disk('public')->delete('banners/'.$banner->image);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename =  'banner'. '_'. BannerType::from($validated['type'])->label().'-'. time() . '.' . $ext;
            $file->storeAs('banners', $filename, 'public');
            $validated['image'] = $filename;

        } else {
            unset($validated['image']);
        }

        unset($validated['id']);

        if ($banner->exists) {
            $banner->update($validated);
            $message = 'بنر با موفقیت ویرایش شد';
        } else {
            Banner::create($validated);
            $message = 'بنر با موفقیت ایجاد شد';
        }

        return redirect()->route('admin.banners.index')->with('success', $message);
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete('banners/'.$banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'بنر با موفقیت حذف شد');
    }
}
