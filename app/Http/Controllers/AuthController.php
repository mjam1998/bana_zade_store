<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(private SmsService $sms) {}

    public function showRegister()
    {
        return view('front.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'mobile' => ['required', 'digits:11', 'regex:/^09[0-9]{9}$/'],
            'password' => 'required|string|min:4|confirmed',
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.string'   => 'نام باید به صورت متن باشد.',
            'name.max'      => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'mobile.required' => 'وارد کردن شماره موبایل الزامی است.',
            'mobile.digits'   => 'شماره موبایل باید ۱۱ رقم باشد.',
            'mobile.regex'    => 'فرمت شماره موبایل صحیح نیست.',

            'password.required'  => 'وارد کردن رمز عبور الزامی است.',
            'password.string'    => 'رمز عبور باید به صورت متن باشد.',
            'password.min'       => 'رمز عبور باید حداقل ۴ کاراکتر باشد.',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد.',
        ]);


        if (User::where('mobile', $data['mobile'])->exists()) {
            return back()->withErrors(['mobile' => 'قبلاً با این شماره موبایل ثبت نام شده است.'])->withInput();
        }

        $code = $this->sms->generateCode();

        $this->sms->sendVerificationCode($data['mobile'], $code,$data['name']);

        session()->put('register_data', [
            'name'           => $data['name'],
            'mobile'         => $data['mobile'],
            'password'       => Hash::make($data['password']),
            'verify_code'    => $code,
            'expires_at'     => now()->addMinutes(2),
        ]);

        return redirect()->route('register.verify');
    }

    public function showVerify()
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register');
        }
        return view('front.auth.register-verify');
    }

    public function verify(Request $request)
    {
        $sessionData = session('register_data');

        if (!$sessionData) {
            return redirect()->route('register');
        }

        $data = $request->validate([
            'code' => 'required|digits:5',
        ], [
            'code.digits' => 'کد باید ۵ رقم باشد',
        ]);

        // بررسی انقضا
        if (now()->gt($sessionData['expires_at'])) {
            session()->forget('register_data');
            return redirect()->route('register')->withErrors(['sms' => 'کد منقضی شده است، دوباره ثبتنام کنید.']);
        }

        // بررسی صحت کد
        if ((int)$data['code'] !== $sessionData['verify_code']) {
            return back()->withErrors(['code' => 'کد وارد شده صحیح نیست.']);
        }

        // ثبت نهایی کاربر
        $user = User::create([
            'name'    => $sessionData['name'],
            'mobile'  => $sessionData['mobile'],
            'password'=> $sessionData['password'],
        ]);

        $user->assignRole('user');

        session()->forget('register_data');
        auth()->login($user);

        return redirect()->route('home')->with('success', 'ثبتنام با موفقیت انجام شد، خوش آمدید!');
    }

    /* ============ فراموشی رمز ============ */

    public function showForgot()
    {
        return view('front.auth.forgot-password');
    }

    public function forgot(Request $request)
    {
        $data = $request->validate([
            'mobile' => ['required', 'digits:11', 'regex:/^09[0-9]{9}$/'],
        ]);

        $user = User::where('mobile', $data['mobile'])->first();

        // همیشه پیام موفق بده تا شماره مشخص نشود (امنیت)
        if (!$user) {
            return back()->with('status', 'در صورت وجود حساب، پیامک ارسال خواهد شد.');
        }

        $code = $this->sms->generateCode();
        $this->sms->sendVerificationCode($data['mobile'], $code,$user->name);

        session()->put('reset_data', [
            'mobile'      => $data['mobile'],
            'verify_code' => $code,
            'expires_at'  => now()->addMinutes(2),
        ]);

        return redirect()->route('password.forgot.verify');
    }

    public function showForgotVerify()
    {
        if (!session()->has('reset_data')) {
            return redirect()->route('password.forgot');
        }
        return view('front.auth.forgot-verify');
    }

    public function forgotVerify(Request $request)
    {
        $sessionData = session('reset_data');

        if (!$sessionData) {
            return redirect()->route('password.forgot');
        }

        $data = $request->validate([
            'code' => 'required|digits:5',
        ]);

        if (now()->gt($sessionData['expires_at'])) {
            session()->forget('reset_data');
            return redirect()->route('password.forgot')->withErrors(['sms' => 'کد منقضی شده است.']);
        }

        if ((int)$data['code'] !== $sessionData['verify_code']) {
            return back()->withErrors(['code' => 'کد وارد شده صحیح نیست.']);
        }

        // کد درست بود، به صفحه تعیین رمز جدید برو
        session()->put('reset_verified', true);

        return redirect()->route('password.reset');
    }

    public function showReset()
    {
        if (!session('reset_verified')) {
            return redirect()->route('password.forgot');
        }
        return view('front.auth.reset-password');
    }

    public function reset(Request $request)
    {
        if (!session('reset_verified')) {
            return redirect()->route('password.forgot');
        }

        $data = $request->validate([
            'password' => 'required|string|min:4|confirmed',
        ],[
            'password.required'  => 'لطفاً رمز عبور جدید را وارد کنید.',
            'password.string'    => 'رمز عبور واردشده معتبر نیست.',
            'password.min'       => 'رمز عبور باید حداقل ۴ کاراکتر باشد.',
            'password.confirmed' => 'تکرار رمز عبور با رمز عبور جدید مطابقت ندارد.',
        ]);

        $user = User::where('mobile', session('reset_data.mobile'))->firstOrFail();
        $user->update(['password' => Hash::make($data['password'])]);

        session()->forget(['reset_data', 'reset_verified']);

        return redirect()->route('login')->with('success', 'رمز عبور با موفقیت تغییر کرد، وارد شوید.');
    }
    public function login()
    {
        return view('front.auth.login');
    }
    public function loginSubmit(Request $request)
    {
        $data = $request->validate([
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
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex'    => 'فرمت شماره موبایل صحیح نیست. (مثال: 09123456789)',
            'mobile.exists'   => 'اطلاعات یافت نشد.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min'      => 'رمز عبور باید حداقل 4 کاراکتر باشد.',
        ]);

        $user = User::where('mobile', $data['mobile'])
            ->where('is_active', true)
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['mobile' => 'اطلاعات یافت نشد.'])->withInput();
        }

        auth()->login($user);

        return $this->redirectAfterLogin($user);
    }

    protected function redirectAfterLogin($user): \Illuminate\Http\RedirectResponse
    {
        $adminRoles = ['admin', 'super-admin', 'manage-category','manage-product',
            'manage-order','manage-blog','manage-banner','manage-extra-page',
            'manage-payment-gateway'];

        $hasUser  = $user->hasRole('user');
        $hasAdmin = $user->hasAnyRole($adminRoles);

        if ($hasUser && $hasAdmin) {
            return redirect()->route('select.panel');
        }

        // فقط ادمین
        if ($hasAdmin) {
            return redirect()->route('admin.index');
        }

       if ($hasUser) {
           return redirect()->route('home');
       }
        return redirect()->route('login');
    }

}
