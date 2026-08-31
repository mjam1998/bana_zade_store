<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('front.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // اگر نیاز به ویرایش ایمیل یا شماره موبایل دارید، اینجا اضافه کنید
            // 'mobile' => 'required|string|size:11|unique:users,mobile,'.$user->id,
        ]);

        $user->update($validated);

        return back()->with('success', 'اطلاعات شما با موفقیت بروزرسانی شد.');
    }

    public function orders()
    {
        return view('front.profile.orders');
    }

    public function showOrder(Order $order)
    {
        // امنيت: كاربر فقط سفارش خودش را ببيند
        abort_if($order->user_id !== auth()->id(), 403, 'شما اجازه دسترسی به این سفارش را ندارید.');

        return view('front.profile.order-detail', compact('order'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));

    }
}
