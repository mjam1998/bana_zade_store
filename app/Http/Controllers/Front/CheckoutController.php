<?php

namespace App\Http\Controllers\Front;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است.');
        }

        $products = Product::whereIn('id', array_keys($cart))->with('category')->get();

        return view('front.checkout.index', compact('cart', 'products'));
    }

    public function store(Request $request)
    {
        // اعتبارسنجی اطلاعات فرم
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'mobile'      => 'required|string|size:11|regex:/^[0-9]+$/',
            'state'       => 'required|string|max:100',
            'city'        => 'required|string|max:100',
            'postal_code' => 'required|string|size:10|regex:/^[0-9]+$/',
            'address'     => 'required|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        DB::beginTransaction();

        try {
            $grandOriginalTotal = 0;
            $grandTotal = 0;
            $orderItemsData = [];

            // محاسبه مجدد و امن قیمت‌ها در بک‌اند
            foreach ($products as $product) {
                $qty = $cart[$product->id];
                $basePrice = $product->base_price;
                $unitPrice = $product->unitPriceFor($qty);

                if ($unitPrice == $basePrice && $product->discount > 0) {
                    $unitPrice = round($basePrice * (1 - $product->discount / 100));
                }

                $itemOriginalTotal = $basePrice * $qty;
                $itemFinalTotal = $unitPrice * $qty;

                $grandOriginalTotal += $itemOriginalTotal;
                $grandTotal += $itemFinalTotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'price'      => $unitPrice,
                    'discount'   => $basePrice - $unitPrice, // مبلغ تخفیف برای یک عدد
                    'quantity'   => $qty,
                ];
            }

            // ایجاد سفارش
            $order = Order::create([
                'user_id'      => auth()->id(),
                'code'         => 'ORD-' . strtoupper(Str::random(8)),
                'status'       => OrderStatus::WaitingSend,
                'name'         => $validated['name'],
                'mobile'       => $validated['mobile'],
                'state'        => $validated['state'],
                'city'         => $validated['city'],
                'address'      => $validated['address'],
                'postal_code'  => $validated['postal_code'],
                'total_amount' => $grandOriginalTotal,
                'pay_amount'   => $grandTotal,
                'is_paid'      => false,
            ]);

            // ثبت اقلام سفارش
            foreach ($orderItemsData as $item) {
                $order->orderItems()->create($item);
            }

            // خالی کردن سبد خرید
            session()->forget('cart');

            DB::commit();

            // در اینجا می‌توانید کاربر را به درگاه پرداخت یا صفحه موفقیت ارجاع دهید
            // return redirect()->route('payment.gateway', $order->id);
            return redirect()->route('home')->with('success', 'سفارش شما با موفقیت ثبت شد و در انتظار پرداخت است.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'خطایی در ثبت سفارش رخ داد: ' . $e->getMessage())->withInput();
        }
    }
}
