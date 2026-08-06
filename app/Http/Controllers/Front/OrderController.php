<?php

namespace App\Http\Controllers\Front;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentGateway;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sub_product_id' => 'nullable|exists:sub_products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        try {
            $productId = $request->product_id;
            $subProductId = $request->sub_product_id;
            $quantity = $request->quantity;

            $cart = session()->get('cart', []);
            $cartKey = $subProductId ? "sub_{$subProductId}" : "product_{$productId}";

            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $quantity;
            } else {
                if ($subProductId) {
                    $subProduct = SubProduct::findOrFail($subProductId);
                    $product = $subProduct->product;

                    $cart[$cartKey] = [
                        'product_id' => $productId,
                        'sub_product_id' => $subProductId,
                        'name' => $product->name . ' - ' . $subProduct->name,
                        'price' => $subProduct->price,
                        'discount' => $subProduct->discount,
                        'final_price' => $subProduct->price - $subProduct->discount,
                        'quantity' => $quantity,
                        'image' => $product->image
                            ? asset('product/' . $product->image)
                            : asset('category/' . $product->category->image),
                        'slug' => $product->slug
                    ];
                } else {
                    $product = Product::findOrFail($productId);

                    $cart[$cartKey] = [
                        'product_id' => $productId,
                        'sub_product_id' => null,
                        'name' => $product->name,
                        'price' => $product->price,
                        'discount' => $product->discount,
                        'final_price' => $product->price - $product->discount,
                        'quantity' => $quantity,
                        'image' => $product->image
                            ? asset('product/' . $product->image)
                            : asset('category/' . $product->category->image),
                        'slug' => $product->slug
                    ];
                }
            }

            session()->put('cart', $cart);
            $count = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'status' => 'success',
                'cart_count' => $count,
                'message' => $quantity > 1 ? "{$quantity} عدد محصول به سبد خرید اضافه شد." : 'محصول به سبد خرید اضافه شد.'
            ]);
        }  catch (Throwable $e) {
            Log::error($e);
            return response()->json([
                'status'  => 'error',
                'message' => 'خطا',
                'debug'   => app()->environment('local') ? [
                    'error' => $e->getMessage(),
                    'file'  => $e->getFile(),
                    'line'  => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ] : null,
            ], 500);
        }

    }

    public function updateCart(Request $request)
    {
        $cartKey = $request->cart_key;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $quantity;
            session()->put('cart', $cart);

            // محاسبه قیمت‌ها
            $totalPrice = 0;
            $totalDiscount = 0;
            $totalQuantity = 0;

            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
                $totalDiscount += $item['discount'] * $item['quantity'];
                $totalQuantity += $item['quantity'];
            }

            $finalTotal = $totalPrice - $totalDiscount;

            return response()->json([
                'status' => 'success',
                'item_total' => number_format($cart[$cartKey]['final_price'] * $quantity),
                'total_price' => number_format($totalPrice),
                'total_discount' => number_format($totalDiscount),
                'final_total' => number_format($finalTotal),
                'cart_count' => $totalQuantity
            ]);
        }

        return response()->json(['status' => 'error'], 404);
    }

    public function removeFromCart(Request $request)
    {
        $cartKey = $request->cart_key;
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);

            if (empty($cart)) {
                return response()->json([
                    'status' => 'success',
                    'cart_empty' => true,
                    'cart_count' => 0
                ]);
            }

            // محاسبه قیمت‌ها
            $totalPrice = 0;
            $totalDiscount = 0;
            $totalQuantity = 0;

            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
                $totalDiscount += $item['discount'] * $item['quantity'];
                $totalQuantity += $item['quantity'];
            }

            $finalTotal = $totalPrice - $totalDiscount;

            return response()->json([
                'status' => 'success',
                'cart_empty' => false,
                'total_price' => number_format($totalPrice),
                'total_discount' => number_format($totalDiscount),
                'final_total' => number_format($finalTotal),
                'cart_count' => $totalQuantity
            ]);
        }

        return response()->json(['status' => 'error'], 404);
    }

    public function clearCart()
    {
        session()->forget('cart');

        return response()->json([
            'status' => 'success',
            'message' => 'سبد خرید خالی شد.'
        ]);
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);

        $totalPrice = 0;
        $totalDiscount = 0;

        foreach($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
            $totalDiscount += $item['discount'] * $item['quantity'];
        }

        $finalTotal = $totalPrice - $totalDiscount;
        $gatewayActive = PaymentGateway::where('is_active', true)->exists();
        return view('front.cart', compact('cart', 'totalPrice', 'totalDiscount', 'finalTotal','gatewayActive'));
    }

    public function checkout()
    {
        $gatewayActive = PaymentGateway::first();
        if ( $gatewayActive->is_active == false ) {
            return view('front.cart');
        }
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'سبد خرید شما خالی است.');
        }

        // محاسبه قیمت‌ها
        $totalPrice = 0;
        $totalDiscount = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
            $totalDiscount += $item['discount'] * $item['quantity'];
        }

        $finalTotal = $totalPrice - $totalDiscount;

        // دریافت روش‌های ارسال
        $sendMethods = \App\Models\SendMethod::all();

        return view('front.checkout', compact('cart', 'totalPrice', 'totalDiscount', 'finalTotal', 'sendMethods'));
    }

    public function processCheckout(Request $request)
    {
        $gatewayActive = PaymentGateway::first();
        if ( $gatewayActive->is_active == false ) {
            return view('front.cart');
        }
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'سبد خرید شما خالی است.');
        }

        // اعتبارسنجی
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|regex:/^09[0-9]{9}$/',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'postal_code' => 'required|string|regex:/^[0-9]{10}$/',
            'send_method_id' => 'required|exists:send_methods,id',
        ], [
            'name.required' => 'نام و نام خانوادگی الزامی است.',
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex' => 'شماره موبایل باید با 09 شروع شده و 11 رقم باشد.',
            'state.required' => 'استان الزامی است.',
            'city.required' => 'شهر الزامی است.',
            'address.required' => 'آدرس الزامی است.',
            'postal_code.required' => 'کد پستی الزامی است.',
            'postal_code.regex' => 'کد پستی باید 10 رقم باشد.',
            'send_method_id.required' => 'روش ارسال الزامی است.',
        ]);

        // بررسی قیمت‌ها از دیتابیس
        $totalPrice = 0;
        $totalDiscount = 0;
        $updatedCart = [];

        foreach ($cart as $cartKey => $item) {
            if (isset($item['sub_product_id']) && $item['sub_product_id']) {
                // محصول با زیر محصول
                $subProduct = SubProduct::find($item['sub_product_id']);

                if (!$subProduct) {
                    return redirect()->route('cart.view')->with('error', 'برخی محصولات سبد خرید شما دیگر موجود نیستند.');
                }

                $product = $subProduct->product;

                if (!$product) {
                    return redirect()->route('cart.view')->with('error', 'برخی محصولات سبد خرید شما دیگر موجود نیستند.');
                }

                $realPrice = $subProduct->price;
                $realDiscount = $subProduct->discount ?? 0;
                $realFinalPrice = $realPrice - $realDiscount;

                $updatedCart[$cartKey] = [
                    'product_id' => $product->id,
                    'sub_product_id' => $subProduct->id,
                    'name' => $product->name . ' - ' . $subProduct->name,
                    'price' => $realPrice,
                    'discount' => $realDiscount,
                    'final_price' => $realFinalPrice,
                    'quantity' => $item['quantity'],
                    'image' => $product->image ?? $product->category->image,
                    'slug' => $product->slug
                ];

            } else {
                // محصول بدون زیر محصول
                $product = Product::find($item['product_id']);

                if (!$product) {
                    return redirect()->route('cart.view')->with('error', 'برخی محصولات سبد خرید شما دیگر موجود نیستند.');
                }

                $realPrice = $product->price;
                $realDiscount = $product->discount ?? 0;
                $realFinalPrice = $realPrice - $realDiscount;

                $updatedCart[$cartKey] = [
                    'product_id' => $product->id,
                    'sub_product_id' => null,
                    'name' => $product->name,
                    'price' => $realPrice,
                    'discount' => $realDiscount,
                    'final_price' => $realFinalPrice,
                    'quantity' => $item['quantity'],
                    'image' => $product->image ?? $product->category->image,
                    'slug' => $product->slug
                ];
            }

            $totalPrice += $updatedCart[$cartKey]['price'] * $item['quantity'];
            $totalDiscount += $updatedCart[$cartKey]['discount'] * $item['quantity'];
        }

        // به‌روزرسانی سبد خرید در session با قیمت‌های واقعی
        session()->put('cart', $updatedCart);

        $finalTotal = $totalPrice - $totalDiscount;

        // ذخیره اطلاعات در session برای استفاده بعد از پرداخت
        session()->put('checkout_data', [
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'state' => $validated['state'],
            'city' => $validated['city'],
            'address' => $validated['address'],
            'postal_code' => $validated['postal_code'],
            'send_method_id' => $validated['send_method_id'],
            'total_amount' => $totalPrice,
            'discount_amount' => $totalDiscount,
            'pay_amount' => $finalTotal,
            'cart' => $updatedCart,
        ]);
        $backUrl=route('pay.call.back');

        $response= Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',

        ])->post('https://sandbox.zarinpal.com/pg/v4/payment/request.json', [
            "merchant_id" => env('ZARINPAL_MERCHANT_ID'),
            "amount" => $finalTotal * 10,
            "description"=>"پرداخت در فروشگاه آقای صفر تا صد",

            "callback_url"=>$backUrl
        ]);

        $result = json_decode($response->getBody(), true);

        $code = $result['data']['code']?? null ;

        if ($code == 100) {
            $authority = $result['data']['authority'];

            return redirect()->away("https://sandbox.zarinpal.com/pg/StartPay/{$authority}");
        }

        return redirect()->back()->with('error','خطا در ایجاد درگاه پرداخت.');
    }

    public function payCallback(Request $request)
    {

        $authority = $request->input('Authority');
        $status = $request->input('Status');

        if ($status == 'OK') {

            $checkoutData = session()->get('checkout_data');
            do {
                $code = strtoupper(Str::random(8));
            } while (Order::where('code', $code)->exists());

           $order= Order::query()->create([
               'code' => $code,
               'authority' => $authority,
               'send_method_id'=>$checkoutData['send_method_id'],
               'name'=>$checkoutData['name'],
               'mobile'=>$checkoutData['mobile'],
               'total_amount'=>$checkoutData['total_amount'],
               'pay_amount'=>$checkoutData['pay_amount'],
               'state'=>$checkoutData['state'],
               'city'=>$checkoutData['city'],
               'address'=>$checkoutData['address'],
               'postal_code'=>$checkoutData['postal_code'],

            ]);

            foreach ($checkoutData['cart'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'sub_product_id' => $item['sub_product_id'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'quantity' => $item['quantity'],
                ]);
            }

            // پاک کردن session
            session()->forget(['cart', 'checkout_data']);

            // تایید پرداخت
            return $this->verifyPayment($code);
        }

        return redirect()->route('checkout')
            ->with('error', 'پرداخت توسط کاربر لغو شد.');

    }


    public function verifyPayment($code)
    {

      $order = Order::query()->where('code', $code)->first();

        $response= Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',

        ])->post('https://sandbox.zarinpal.com/pg/v4/payment/verify.json', [
            "merchant_id" => env('ZARINPAL_MERCHANT_ID'),
            "amount" => $order->pay_amount * 10,
            "authority"=>$order->authority
        ]);

        $result = $response->json();

        if ($result['data']['code'] == 100 || 101){
            $order->update([
                'is_paid'=>true,
                'ref_id'=>$result['data']['ref_id'],
                'paid_at' => now()
            ]);

            $admin=User::query()->where('type',UserType::Primary)->first();

            //پیامک به ادمین
            Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'text/plain',
                'x-api-key' => env('SMS_IR_API_KEY')
            ])->post('https://api.sms.ir/v1/send/verify', [
                "mobile" => $admin->mobile,
                "templateId" => 622998,
                "parameters" => [
                    [
                        "name" => "CODE",
                        "value" => $order->code
                    ]
                ]
            ]);

            //پیامک به مشتری
            Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'text/plain',
                'x-api-key' => env('SMS_IR_API_KEY')
            ])->post('https://api.sms.ir/v1/send/verify', [
                "mobile" => $order->mobile,
                "templateId" => 833510,
                "parameters" => [
                    [
                        "name" => "NAME",
                        "value" => $order->name
                    ],[
                        "name" => "CODE",
                        "value" => $order->code
                    ],[
                        "name" => "AMOUNT",
                        "value" => $order->pay_amount
                    ]
                ]
            ]);

            return redirect()->route('pay.result',['code'=>encrypt( $order->code)]);
        }
        $order->update([
            'is_paid'=>false
            ,
        ]);
        return redirect()->route('pay.result',['code'=>encrypt( $order->code)]);
    }

    public function payResult($code)
    {
        $code=decrypt($code);
       $order=Order::query()->where('code', $code)->first();

       if (!$order) {
           abort(404);
       }

       if (!$order->is_paid){
           $failed=true;
       }else{
           $failed=false;
       }
        return view('front.pay-result', compact('order','failed'));
    }

    public function trackOrder()
    {
        return view('front.order-track');
    }

    // پردازش کد سفارش و نمایش جزئیات
    public function trackOrderResult(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string|exists:orders,code',
        ], [
            'order_code.required' => 'لطفاً کد سفارش را وارد کنید.',
            'order_code.string'   => 'کد سفارش نامعتبر است.',
            'order_code.exists'   => 'سفارشی با این کد یافت نشد.',
        ]);



        $order = Order::with([
            'orderItems.product' => fn($q) => $q->withTrashed(),
            'sendMethod'=> fn($q) => $q->withTrashed()
        ])
            ->where('code', $request->input('order_code'))
            ->first();



        if (!$order->is_paid) {

           abort(404);
        }

        return view('front.order-track-result', compact('order'));
    }
}
