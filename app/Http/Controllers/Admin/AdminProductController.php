<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\SubProduct;
use App\Rules\SlugRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminProductController extends Controller
{
    public function index(){
        return view('admin.product.index');
    }

    public function create(){
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'              => 'required|string|max:400',
            'slug'              => ['required', 'string', 'max:400', 'unique:products,slug', new SlugRule()],
            'unit_name'         => 'required|string|max:400',
            'min_shop_count'    => 'required|integer|min:1',
            'count'             => 'required|integer|min:0',
            'base_price'        => 'required|numeric|min:0',
            'discount'          => 'nullable|numeric|min:0|max:100',
            'description'       => 'nullable',
            'meta_title'        => 'nullable|string|max:400',
            'meta_description'  => 'nullable|string|max:400',
            'keywords'          => 'nullable|string|max:400',
            'is_special'        => 'nullable|boolean',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp,jfif|max:5148',
            'image_alt'         => 'nullable|string|max:400',
            'image_title'       => 'nullable|string|max:400',

            // اعتبارسنجی پله‌ها
            'tiers'               => 'nullable|array',
            'tiers.*.min_qty'     => 'required_with:tiers|integer|min:1',
            'tiers.*.max_qty'     => 'nullable|integer|min:1',
            'tiers.*.unit_price'  => 'required_with:tiers|numeric|min:0',
        ], [
            'category_id.required' => 'انتخاب دسته‌بندی الزامی است.',
            'category_id.exists'   => 'دسته‌بندی انتخاب شده معتبر نیست.',

            'name.required' => 'وارد کردن نام محصول الزامی است.',
            'name.max'       => 'طول نام محصول نباید بیشتر از ۴۰۰ کاراکتر باشد.',

            'slug.required' => 'وارد کردن اسلاگ الزامی است.',
            'slug.max'       => 'طول اسلاگ نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'slug.unique'    => 'این اسلاگ قبلاً استفاده شده است.',
            'image.image' => 'فایل انتخابی باید تصویر باشد',
            'image.mimes' => 'فرمت تصویر باید jpeg، png، jpg,jfif یا webp باشد',
            'image.max' => 'حجم تصویر نباید بیشتر از 5 مگابایت باشد',
            'code.required' => 'وارد کردن کد محصول الزامی است.',
            'code.max'       => 'طول کد محصول نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'code.unique'    => 'این کد محصول قبلاً ثبت شده است.',

            'size.max' => 'طول مقدار سایز نباید بیشتر از ۴۰۰ کاراکتر باشد.',

            'count.integer'  => 'مقدار موجودی باید عدد صحیح باشد.',
            'count.min'      => 'مقدار موجودی نمی‌تواند منفی باشد.',
            'count.required'      => 'مقدار موجودی نمی‌تواند خالی باشد.',

            'price.required' => 'وارد کردن قیمت الزامی است.',
            'price.numeric'  => 'قیمت باید یک مقدار عددی باشد.',
            'price.min'      => 'قیمت نمی‌تواند منفی باشد.',

            'discount.numeric' => 'تخفیف باید یک مقدار عددی باشد.',
            'discount.min'     => 'تخفیف نمی‌تواند منفی باشد.',

            'description.required' => 'توضیحات الزامی هست.',

            'meta_title.max'         => 'طول meta title نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'meta_description.max'   => 'طول meta description نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'keywords.max'           => 'طول کلمات کلیدی نباید بیشتر از ۴۰۰ کاراکتر باشد.',

            'image_alt.max'          => 'طول متن جایگزین تصویر نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'image_title.max'        => 'طول عنوان تصویر نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'unit_name.required'      => 'وارد کردن واحد اندازه‌گیری الزامی است.',
            'min_shop_count.required' => 'حداقل تعداد خرید الزامی است.',
            'base_price.required'     => 'وارد کردن قیمت پایه الزامی است.',

            'tiers.*.min_qty.required_with'    => 'مقدار «از تعداد» الزامی است.',
            'tiers.*.unit_price.required_with' => 'قیمت واحد پله الزامی است.',
        ]);

        if (!empty($data['tiers'])) {
            $this->validateTiers($data['tiers']);
        }

        if ($request->hasFile('image')) {
            $filename = $data['slug'] . "_" . time() . ".webp";

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image'));
            $encoded = $image->encode(new WebpEncoder(quality: 80));

            Storage::disk('public')->put('product/' . $filename, (string) $encoded);
            $data['image'] = $filename;
        }

        $product = Product::create($data);

        // ذخیره پله‌های قیمتی
        foreach ($data['tiers'] ?? [] as $tier) {
            if (empty($tier['min_qty'])) continue;

            $product->productPriceTiers()->create([
                'min_qty'    => $tier['min_qty'],
                'max_qty'    => $tier['max_qty'] ?? null,
                'unit_price' => $tier['unit_price'],
            ]);
        }

        return redirect()->route('admin.product.index')->with('success', 'محصول با موفقیت افزوده شد.');
    }
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.product.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'             => 'required|string|max:400',
            'slug'             => [
                'required',
                'string',
                'max:400',
                'unique:products,slug,' . $product->id,
                new SlugRule(),
            ],
            'unit_name'        => 'required|string|max:400',
            'min_shop_count'   => 'required|integer|min:1',
            'count'            => 'required|integer|min:0',
            'base_price'       => 'required|numeric|min:0',
            'discount'         => 'nullable|numeric|min:0|max:100',
            'description'      => 'nullable',
            'meta_title'       => 'nullable|string|max:400',
            'meta_description' => 'nullable|string|max:400',
            'keywords'         => 'nullable|string|max:400',
            'is_special'       => 'nullable|boolean',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp,jfif|max:5148',
            'image_alt'        => 'nullable|string|max:400',
            'image_title'      => 'nullable|string|max:400',

            'tiers'               => 'nullable|array',
            'tiers.*.min_qty'     => 'required_with:tiers|integer|min:1',
            'tiers.*.max_qty'     => 'nullable|integer|min:1',
            'tiers.*.unit_price'  => 'required_with:tiers|numeric|min:0',
        ], [
            'category_id.required' => 'انتخاب دسته‌بندی الزامی است.',
            'category_id.exists'   => 'دسته‌بندی انتخاب شده معتبر نیست.',

            'name.required' => 'وارد کردن نام محصول الزامی است.',
            'name.max'      => 'طول نام محصول نباید بیشتر از ۴۰۰ کاراکتر باشد.',

            'slug.required' => 'وارد کردن اسلاگ الزامی است.',
            'slug.max'      => 'طول اسلاگ نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'slug.unique'   => 'این اسلاگ قبلاً استفاده شده است.',

            'image.image' => 'فایل انتخابی باید تصویر باشد',
            'image.mimes' => 'فرمت تصویر باید jpeg، png، jpg، jfif یا webp باشد',
            'image.max'   => 'حجم تصویر نباید بیشتر از 5 مگابایت باشد',

            'unit_name.required'      => 'وارد کردن واحد اندازه‌گیری الزامی است.',
            'min_shop_count.required' => 'حداقل تعداد خرید الزامی است.',
            'base_price.required'     => 'وارد کردن قیمت پایه الزامی است.',

            'count.integer' => 'مقدار موجودی باید عدد صحیح باشد.',
            'count.min'     => 'مقدار موجودی نمی‌تواند منفی باشد.',
            'count.required'      => 'مقدار موجودی نمی‌تواند خالی باشد.',

            'discount.numeric' => 'تخفیف باید یک مقدار عددی باشد.',
            'discount.min'     => 'تخفیف نمی‌تواند منفی باشد.',
            'discount.max'     => 'تخفیف نمی‌تواند بیشتر از ۱۰۰ باشد.',

            'meta_title.max'       => 'طول meta title نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'meta_description.max' => 'طول meta description نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'keywords.max'         => 'طول کلمات کلیدی نباید بیشتر از ۴۰۰ کاراکتر باشد.',

            'image_alt.max'   => 'طول متن جایگزین تصویر نباید بیشتر از ۴۰۰ کاراکتر باشد.',
            'image_title.max' => 'طول عنوان تصویر نباید بیشتر از ۴۰۰ کاراکتر باشد.',

            'tiers.*.min_qty.required_with'    => 'مقدار «از تعداد» الزامی است.',
            'tiers.*.unit_price.required_with' => 'قیمت واحد پله الزامی است.',
        ]);

        if (!empty($data['tiers'])) {
            $this->validateTiers($data['tiers']);
        }

        // مدیریت تصویر (تبدیل به webp)
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete('product/' . $product->image);
            }

            $filename = $data['slug'] . '_' . time() . '.webp';

            $manager = new ImageManager(new Driver());
            $image = $manager->decode($request->file('image'));
            $encoded = $image->encode(new WebpEncoder(quality: 80));

            Storage::disk('public')->put('product/' . $filename, (string) $encoded);
            $data['image'] = $filename;
        }

        $tiers = $data['tiers'] ?? [];
        unset($data['tiers']);

        $product->update($data);

        // به‌روزرسانی پله‌های قیمتی: حذف قبلی‌ها و درج مجدد
        $product->productPriceTiers()->delete();

        foreach ($tiers as $tier) {
            if (empty($tier['min_qty'])) continue;

            $product->productPriceTiers()->create([
                'min_qty'    => $tier['min_qty'],
                'max_qty'    => $tier['max_qty'] ?? null,
                'unit_price' => $tier['unit_price'],
            ]);
        }

        return back()->with('success', 'محصول با موفقیت ویرایش شد.');
    }

    public function delete(Product $product)
    {
        $product->delete();
        return back()->with('success',' محصول با موفقیت حذف شد.');
    }

    public function commentList(Product $product)
    {
        return view('admin.product.comment.index', compact('product'));
    }
    public function commentCreate(Product $product)
    {
        return view('admin.product.comment.create', compact('product'));
    }
    public function commentStore(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
            'status' => 'required|integer',
            'admin_response' => 'nullable|string',
            'created_at' => 'required|string',
        ], [
            'name.required' => 'نام نظر دهنده الزامی است',
            'name.string' => 'نام باید متن باشد',
            'name.max' => 'نام نباید بیشتر از 255 کاراکتر باشد',
            'comment.required' => 'متن نظر الزامی است',
            'comment.string' => 'نظر باید متن باشد',
            'status.required' => 'وضعیت الزامی است',
            'status.integer' => 'وضعیت باید عدد باشد',
            'admin_response.string' => 'پاسخ ادمین باید متن باشد',
            'created_at.required' => 'تاریخ نظر الزامی است',
            'created_at.string' => 'فرمت تاریخ نامعتبر است',
        ]);

        try {
            // تبدیل تاریخ شمسی به میلادی
            $gregorianDate = \Morilog\Jalali\Jalalian::fromFormat('Y/n/j', $validated['created_at'])
                ->toCarbon();

            Comment::create([
                'product_id' => $product->id,
                'name' => $validated['name'],
                'comment' => $validated['comment'],
                'status' => $validated['status'],
                'admin_response' => $validated['admin_response'],
                'created_at' => $gregorianDate,
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.product.comment.list',['product'=>$product])->with('success', 'کامنت با موفقیت افزوده شد');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'خطا در ذخیره کامنت: فرمت تاریخ نامعتبر است')->withInput();
        }
    }
    public function commentEdit(Product $product, Comment $comment)
    {
        // بررسی اینکه کامنت متعلق به این محصول است
        if ($comment->product_id !== $product->id) {
            return redirect()->route('admin.product.comment.list', $product)
                ->with('error', 'کامنت مورد نظر یافت نشد');
        }

        return view('admin.product.comment.edit', compact('product', 'comment'));
    }

    public function commentUpdate(Request $request, Product $product, Comment $comment)
    {
        // بررسی اینکه کامنت متعلق به این محصول است
        if ($comment->product_id !== $product->id) {
            return redirect()->route('admin.product.comment.list', $product)
                ->with('error', 'کامنت مورد نظر یافت نشد');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
            'status' => 'required|integer',
            'admin_response' => 'nullable|string',
            'created_at' => 'required|string',
        ], [
            'name.required' => 'نام نظر دهنده الزامی است',
            'name.string' => 'نام باید متن باشد',
            'name.max' => 'نام نباید بیشتر از 255 کاراکتر باشد',
            'comment.required' => 'متن نظر الزامی است',
            'comment.string' => 'نظر باید متن باشد',
            'status.required' => 'وضعیت الزامی است',
            'status.integer' => 'وضعیت باید عدد باشد',
            'status.in' => 'وضعیت انتخاب شده نامعتبر است',
            'admin_response.string' => 'پاسخ ادمین باید متن باشد',
            'created_at.required' => 'تاریخ نظر الزامی است',
            'created_at.string' => 'فرمت تاریخ نامعتبر است',
        ]);

        try {
            // تبدیل تاریخ شمسی به میلادی
            $gregorianDate = \Morilog\Jalali\Jalalian::fromFormat('Y/n/j', $validated['created_at'])
                ->toCarbon()
                ->format('Y-m-d H:i:s');

            $comment->name = $validated['name'];
            $comment->comment = $validated['comment'];
            $comment->status = $validated['status'];
            $comment->admin_response = $validated['admin_response'];
            $comment->created_at = $gregorianDate;
            $comment->save();

            return redirect()->route('admin.product.comment.list', $product)
                ->with('success', 'کامنت با موفقیت بروزرسانی شد');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'خطا در بروزرسانی کامنت: فرمت تاریخ نامعتبر است')
                ->withInput();
        }
    }
    public function commentDelete(Comment $comment)
    {
        $comment->delete();
        return back()
            ->with('success', 'کامنت با موفقیت حذف شد');
    }

    public function changeStatus(Product $product)
    {

        if ($product->is_active){
            $product->update(['is_active' => false]);
        }else{
            $product->update(['is_active' => true]);
        }
        return back()->with('success','وضعیت محصول با موفقیت تغییر کرد.');
    }
    protected function validateTiers(array $tiers): void
    {
        $tiers = array_values(array_filter($tiers, fn ($t) => !empty($t['min_qty'])));
        usort($tiers, fn ($a, $b) => $a['min_qty'] <=> $b['min_qty']);

        foreach ($tiers as $i => $tier) {
            $min = (int) $tier['min_qty'];
            $max = isset($tier['max_qty']) && $tier['max_qty'] !== '' ? (int) $tier['max_qty'] : null;
            $isLast = $i === count($tiers) - 1;

            if ($max !== null && $max < $min) {
                throw ValidationException::withMessages([
                    "tiers.$i.max_qty" => "مقدار «تا تعداد» نباید کمتر از «از تعداد» باشد.",
                ]);
            }

            if ($max === null && !$isLast) {
                throw ValidationException::withMessages([
                    "tiers.$i.max_qty" => "پله با «تا تعداد» خالی باید آخرین پله باشد.",
                ]);
            }

            if (!$isLast) {
                $nextMin = (int) $tiers[$i + 1]['min_qty'];
                if ($max === null || $max >= $nextMin) {
                    throw ValidationException::withMessages([
                        "tiers.$i" => "بازه {$min} تا " . ($max ?? '∞') . " با پله بعدی همپوشانی دارد.",
                    ]);
                }
            }
        }
    }

}
