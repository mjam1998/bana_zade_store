<?php

namespace App\Http\Controllers\Front;



use App\Enums\BannerType;
use App\Enums\CommentStatus;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Product;
use App\Models\SuperCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $sliders=Banner::query()->where('type',BannerType::Slider)->get();
         $superCategories=SuperCategory::all();
         $discountBanner=Banner::query()->where('type',BannerType::DiscountBanner)->first();
         $blogs=Blog::query()->take(8)->orderByDesc('created_at')->get();
         $banner1=Banner::query()->where('type',BannerType::BannerOne)->first();
         $banner2=Banner::query()->where('type',BannerType::BannerTwo)->first();
         $banner3=Banner::query()->where('type',BannerType::BannerThree)->first();
         $banner4=Banner::query()->where('type',BannerType::BannerFour)->first();
       return view('front.index',['sliders'=>$sliders,
           'superCategories'=>$superCategories,
           'discountBanner'=>$discountBanner
       ,'blogs'=>$blogs,
           'banner1'=>$banner1,
           'banner2'=>$banner2,
           'banner3'=>$banner3,
           'banner4'=>$banner4,]);
   }
   public function login()
   {
       return view('front.login');
   }
   public function loginSubmit(Request $request)
   {
     $data=$request->validate([
         'mobile' => [
         'required',
         'regex:/^09[0-9]{9}$/',
         'exists:users,mobile'
     ],
         'password' => [
             'required',
             'min:4'
         ]
     ], [
         // پیام‌های خطای mobile
         'mobile.required' => 'شماره موبایل الزامی است.',
         'mobile.regex' => 'فرمت شماره موبایل صحیح نیست. (مثال: 09123456789)',
         'mobile.exists' => 'اطلاعات یافت نشد.',

         // پیام‌های خطای password
         'password.required' => 'رمز عبور الزامی است.',
         'password.min' => 'رمز عبور باید حداقل 4 کاراکتر باشد.'
     ]);
       $user = User::where('mobile', $data['mobile'])->first();

       if (!Hash::check($data['password'], $user->password)) {
           return back()->withErrors([
               'mobile' => 'اطلاعات یافت نشد.'
           ])->withInput();
       }

       auth()->login($user);
       return redirect(route('admin.index'));
   }

    public function search(Request $request)
    {
        $q = $request->search;
        $sort = $request->get('sort', 'newest');
        $categoryId = $request->get('category');

        $query = Product::query()
            ->leftJoin('sub_products', function($join) {
                $join->on('products.id', '=', 'sub_products.product_id')
                    ->whereNull('sub_products.deleted_at');
            })
            ->select('products.*')
            ->selectRaw('COALESCE(MIN(sub_products.price), products.price) as final_price')
            ->groupBy('products.id');

        if ($q) {
            $query->where(function ($query) use ($q) {
                $query->where('products.name', 'like', "%{$q}%")
                    ->orWhere('products.code', 'like', "%{$q}%");
            });

        }
        if ($categoryId) {
            $query->where('products.category_id', $categoryId);
        }
        switch($sort) {
            case 'price_asc':
                $query->orderBy('final_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('final_price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('products.created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);

        $categories = Category::all();

        return view('front.search', compact('products', 'categories'));
    }


    public function category($slug){
        $category = Category::query()->where('slug', $slug)->first();

        // دریافت پارامتر مرتب‌سازی
        $sort = request('sort', 'newest');
        $search = request('search');
        // شروع query
        $query = $category->products()
            ->leftJoin('sub_products', function($join) {
                $join->on('products.id', '=', 'sub_products.product_id');
            })
            ->select('products.*')
            ->selectRaw('COALESCE(MIN(sub_products.price), products.price) as final_price')
            ->groupBy('products.id');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('products.name', 'like', "%{$search}%")
                    ->orWhere('products.code', 'like', "%{$search}%");
            });

        }

        // اعمال مرتب‌سازی
        switch($sort) {
            case 'price_asc':
                $query->orderBy('final_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('final_price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('products.created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);

        return view('front.category', compact('category', 'products'));
    }

    public function blogs(){
        $search = request('search');

        // Query اصلی
        $query = Blog::query();

        // اعمال جستجو
        if ($search) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        // دریافت جدیدترین مقاله برای نمایش بزرگ
        $latestBlog = Blog::latest()->first();

        // دریافت 2 مقاله بعدی
        $featuredBlogs = Blog::latest()
            ->skip(1)
            ->take(2)
            ->get();

        // دریافت بقیه مقالات با pagination
        $blogs = $query->latest()
            ->skip(3)
            ->paginate(12);

        return view('front.blogs', compact('latestBlog', 'featuredBlogs', 'blogs'));
    }

    public function blogShow($slug){
        $blog = Blog::query()->where('slug', $slug)->first();
        if (!$blog) {
            abort(404);
        }
        // دریافت مقالات مرتبط (از همان دسته‌بندی یا جدیدترین‌ها)
        $relatedBlogs = Blog::where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return view('front.blog-show', compact('blog', 'relatedBlogs'));
    }

    public function show($slug)
    {
        $product = Product::with([
            'category',
            'subProducts',
            'comments'
        ])->where('slug', $slug)->first();
         $approvedComments = $product->comments()->where('status',CommentStatus::Accepted)->orderByDesc('created_at')->paginate(5);
        // انتخاب اولین sub-product به عنوان پیش‌فرض (اگر وجود داشته باشد)
        $selectedSubProduct = $product->subProducts->first();

        // تعیین قیمت نهایی
        if ($selectedSubProduct) {
            $finalPrice = $selectedSubProduct->discount > 0
                ? $selectedSubProduct->price - $selectedSubProduct->discount
                : $selectedSubProduct->price;
            $originalPrice = $selectedSubProduct->price;
            $discountPercentage = round(($selectedSubProduct->discount* 100 / $selectedSubProduct->price));
        } else {
            $finalPrice = $product->discount > 0
                ? $product->price - $product->discount
                : $product->price;
            $originalPrice = $product->price;
            $discountPercentage = round(($product->discount* 100 / $product->price));
        }

        $keywords = [];
        if (!empty($product->keywords)) {
            $decoded = is_string($product->keywords)
                ? json_decode($product->keywords, true)
                : $product->keywords;

            // استخراج مقدار value از هر آیتم
            if (is_array($decoded)) {
                $keywords = array_map(function($item) {
                    return is_array($item) && isset($item['value']) ? $item['value'] : $item;
                }, $decoded);
            }
        }

        return view('front.product-detail', compact(
            'product',
            'selectedSubProduct',
            'finalPrice',
            'originalPrice',
            'discountPercentage',
            'keywords',
            'approvedComments'
        ));
    }

    /**
     * ذخیره نظر جدید
     */
    public function storeComment(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

            'comment' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'نام الزامی است',
            'name.max' => 'نام نباید بیشتر از 255 کاراکتر باشد',
            'comment.required' => 'متن نظر الزامی است',
            'comment.min' => 'نظر باید حداقل 10 کاراکتر باشد',
            'comment.max' => 'نظر نباید بیشتر از 1000 کاراکتر باشد',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $product = Product::query()->where('slug', $slug)->first();

        Comment::create([

            'product_id' => $product->id,
            'name' => $request->name,
            'comment' => $request->comment,
            'status' => \App\Enums\CommentStatus::Waiting,
        ]);

        return redirect()->back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.');
    }

    public function page($slug)
    {
        $page = Page::query()->where('slug', $slug)->first();
        if (!$page) {
            abort(404);
        }
        return view('front.dynomic-page', compact('page'));

    }
}
