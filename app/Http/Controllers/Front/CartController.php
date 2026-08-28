<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::with('productPriceTiers')->whereIn('id', $productIds)->get();

        return view('front.cart', compact('cart', 'products'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        // اگر محصول از قبل در سبد بود، تعداد را اضافه کن
        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;
        } else {
            $cart[$product->id] = $quantity;
        }

        // اعتبار سنجی حداقل خرید و موجودی
        $min = $product->min_shop_count ?: 1;
        if ($cart[$product->id] < $min) {
            $cart[$product->id] = $min;
        }
        if ($cart[$product->id] > $product->count) {
            return response()->json(['success' => false, 'message' => 'موجودی محصول کافی نیست.']);
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'محصول به سبد خرید اضافه شد.',
            'cartItemCount' => count($cart)
        ]);
    }

    public function update(Request $request, $id)
    {
        $quantity = (int)$request->input('quantity');
        $product = Product::findOrFail($id);

        if ($quantity < ($product->min_shop_count ?: 1) || $quantity > $product->count) {
            return response()->json(['success' => false, 'message' => 'تعداد نامعتبر است.'], 400);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id] = $quantity;
            session()->put('cart', $cart);

            // محاسبه داده‌های جدید برای آیتم و کل سبد
            $updatedData = $this->getCartData($id);

            return response()->json(['success' => true] + $updatedData);
        }

        return response()->json(['success' => false, 'message' => 'محصول در سبد یافت نشد.'], 404);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            // محاسبه داده‌های جدید کل سبد بعد از حذف
            $cartData = $this->getCartData();

            return response()->json([
                'success' => true,
                'message' => 'محصول از سبد حذف شد.',
                'cartItemCount' => count($cart),
                'cartData' => $cartData['cartData'] // فقط داده‌های کلی سبد را بفرست
            ]);
        }
        return response()->json(['success' => false, 'message' => 'محصول یافت نشد.'], 404);
    }

    /**
     * متد کمکی برای محاسبه قیمت‌ها و تخفیف‌ها
     * @param int|null $updatedItemId - آی‌دی محصولی که آپدیت شده
     * @return array
     */
    private function getCartData(int $updatedItemId = null): array
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::with('productPriceTiers')->whereIn('id', $productIds)->get()->keyBy('id');

        $grandOriginalTotal = 0;
        $grandTotal = 0;
        $itemData = null;

        foreach ($cart as $id => $qty) {
            if (!isset($products[$id])) continue;

            $product = $products[$id];
            $basePrice = $product->base_price;
            $unitPrice = $product->unitPriceFor($qty);

            if ($unitPrice == $basePrice && $product->discount > 0) {
                $unitPrice = round($basePrice * (1 - $product->discount / 100));
            }

            $itemOriginalTotal = $basePrice * $qty;
            $itemFinalTotal = $unitPrice * $qty;

            $grandOriginalTotal += $itemOriginalTotal;
            $grandTotal += $itemFinalTotal;

            // اگر این همان آیتمی است که آپدیت شده، جزئیاتش را هم آماده کن
            if ($id === $updatedItemId) {
                $itemDiscountPercent = $basePrice > 0 ? round(($basePrice - $unitPrice) / $basePrice * 100) : 0;
                $itemData = [
                    'id' => $id,
                    'finalTotal' => $itemFinalTotal,
                    'originalTotal' => $itemOriginalTotal,
                    'discountPercent' => $itemDiscountPercent,
                ];
            }
        }

        return [
            'itemData' => $itemData,
            'cartData' => [
                'grandTotal' => $grandTotal,
                'grandOriginalTotal' => $grandOriginalTotal,
                'totalDiscount' => $grandOriginalTotal - $grandTotal,
            ],
            'cartItemCount' => count($cart)
        ];
    }
}
