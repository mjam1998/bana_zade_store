<?php

namespace App\Http\Controllers\Front;



use App\Enums\BannerType;
use App\Enums\CommentStatus;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use App\Models\VideoBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $categories=Category::query()->where('is_active',true)->latest()->take(15)->get();
        $specialsProducts=Product::query()
            ->with(['category'])
            ->where('is_active',true)
            ->where('is_special',true)
            ->latest()->take(12)
            ->get();

        $products=Product::query()
            ->with(['category'])
            ->where('is_active',true)
            ->latest()->take(12)
            ->get();

        $blogs=Blog::query()->latest()->take(6)->get();

        $video=VideoBanner::query()->first();

       return view('front.index', compact('categories','specialsProducts','products','blogs','video'));
   }
    public function categories()
    {
        $categories = Category::where('is_active', true)
            ->select('id','name', 'slug', 'image', 'image_alt', 'image_title')
            ->orderBy('name')
            ->get();

        return view('front.category', compact('categories'));
    }
    public function products(Request $request)
    {
        $validated = $request->validate([
            'search'       => ['nullable', 'string', 'max:300'],
            'category'     => ['nullable', 'string', 'max:300'],
            'min_price'    => ['nullable', 'integer', 'min:0'],
            'max_price'    => ['nullable', 'integer', 'min:0'],
            'has_discount' => ['nullable', 'in:0,1'],
            'sort'         => ['nullable', 'in:newest,cheapest,expensive'],
        ]);

        $query = Product::query()
            ->with([
                'category:id,name,slug,image,image_alt,image_title',
            ])
            ->where('is_active', true)

            ->select([
                'id',
                'name',
                'slug',
                'base_price',
                'discount',
                'image',
                'image_alt',
                'image_title',
                'unit_name',
                'min_shop_count',
                'is_special',
                'created_at',
                'category_id',
            ]);

        // جست‌وجوی نام محصول
        if (!empty($validated['search'])) {
            $query->where('name', 'like', '%' . $validated['search'] . '%');

        }

        // فیلتر با slug دسته‌بندی
        if (!empty($validated['category'])) {
            $query->whereHas('category', function ($categoryQuery) use ($validated) {
                $categoryQuery->where('slug', $validated['category']);
            });
        }

        if (isset($validated['min_price'])) {
            $query->where('base_price', '>=', $validated['min_price']);
        }

        if (isset($validated['max_price'])) {
            $query->where('base_price', '<=', $validated['max_price']);
        }

        if (($validated['has_discount'] ?? null) === '1') {
            $query->where('discount', '>', 0);
        }

        match ($validated['sort'] ?? 'newest') {
            'cheapest'  => $query->orderBy('base_price'),
            'expensive' => $query->orderByDesc('base_price'),
            default     => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $maxPrice = Product::query()
            ->where('is_active', true)
            ->max('base_price') ?? 1_000_000;

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('front.products', compact(
            'products',
            'maxPrice',
            'categories'
        ));
    }

    public function productShow($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'category',
                'productPriceTiers' => function ($query) {
                    $query->orderBy('min_qty', 'asc');
                },
            ])
            ->firstOrFail();

        $comments = $product->comments()
            ->where('status', CommentStatus::Accepted)
            ->latest()
            ->paginate(10);

        return view('front.product-detail', compact('product', 'comments'));
    }

    public function storeComment(Request $request, $slug)
    {
        $product = Product::where('is_active',true)->where('slug',$slug)->firstOrFail();


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string|max:2500',
        ], [
            'name.required' => 'لطفاً نام خود را وارد کنید.',
            'comment.required' => 'لطفاً متن نظر را وارد کنید.',
            'comment.max' => 'حداکثر طول نظر 2500 کاراکتر است.',
        ]);

        $product->comments()->create([
            'name' => $validated['name'],
            'comment' => $validated['comment'],
            'status' => CommentStatus::Waiting,
        ]);

        return back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از بررسی منتشر خواهد شد.');
    }

    public function blogs(Request $request)
    {
        $search = $request->get('search');

        $blogs = Blog::when($search, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('front.blogs', compact('blogs', 'search'));
    }


    public function blogShow(Blog $blog)
    {
        $relatedBlogs = Blog::where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return view('front.blog-show', compact('blog', 'relatedBlogs'));
    }
    public function page($slug)
    {
        $page = Page::query()->where('slug', $slug)->first();
        if (!$page) {
            abort(404);
        }
        return view('front.dynomic-page', compact('page'));

    }

    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('front.dynomic-page', compact('page'));
    }

}
