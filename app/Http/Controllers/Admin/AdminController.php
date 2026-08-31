<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(){

        $dailySales = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Jalalian::now()->subDays($i)->format('m/d');
            $dailySales[$date] = 0;
        }
        $orders30Days = Order::where('is_paid', true)
            ->where('paid_at', '>=', now()->subDays(30))
            ->get(['pay_amount', 'paid_at']);

        foreach ($orders30Days as $order) {
            // اگر paid_at خالی بود از created_at استفاده کند
            $dateObj = $order->paid_at ?? $order->created_at;
            $jDate = Jalalian::fromCarbon($dateObj)->format('m/d');
            if (isset($dailySales[$jDate])) {
                $dailySales[$jDate] += $order->pay_amount;
            }
        }

// 2. آمار ماهانه (سال شمسی جاری)
        $monthlySales = [
            'فروردین' => 0, 'اردیبهشت' => 0, 'خرداد' => 0, 'تیر' => 0, 'مرداد' => 0, 'شهریور' => 0,
            'مهر' => 0, 'آبان' => 0, 'آذر' => 0, 'دی' => 0, 'بهمن' => 0, 'اسفند' => 0
        ];
        $currentJalaliYear = Jalalian::now()->getYear();
        $startOfYear = (new Jalalian($currentJalaliYear, 1, 1))->toCarbon();

        $ordersYear = Order::where('is_paid', true)
            ->where('paid_at', '>=', $startOfYear)
            ->get(['pay_amount', 'paid_at']);

        $monthsList = array_keys($monthlySales);
        foreach ($ordersYear as $order) {
            $dateObj = $order->paid_at ?? $order->created_at;
            $jDate = Jalalian::fromCarbon($dateObj);
            if ($jDate->getYear() == $currentJalaliYear) {
                $monthName = $monthsList[$jDate->getMonth() - 1];
                $monthlySales[$monthName] += $order->pay_amount;
            }
        }

// 3. آمار سالانه (5 سال اخیر)
        $yearlySales = [];
        for ($i = 4; $i >= 0; $i--) {
            $yearlySales[$currentJalaliYear - $i] = 0;
        }
        $startOf5Years = (new Jalalian($currentJalaliYear - 4, 1, 1))->toCarbon();
        $orders5Years = Order::where('is_paid', true)
            ->where('paid_at', '>=', $startOf5Years)
            ->get(['pay_amount', 'paid_at']);

        foreach ($orders5Years as $order) {
            $dateObj = $order->paid_at ?? $order->created_at;
            $year = Jalalian::fromCarbon($dateObj)->getYear();
            if (isset($yearlySales[$year])) {
                $yearlySales[$year] += $order->pay_amount;
            }
        }
        $stats = [
            'products'      => Product::count(),
            'categories'    => Category::count(),
            'orders'        => Order::count(),
            'waiting_send'  => Order::where('status', \App\Enums\OrderStatus::WaitingSend)->count(),
            'sent'          => Order::where('status', \App\Enums\OrderStatus::Sent)->count(),
        ];

        return view('admin.index',compact('stats', 'dailySales', 'monthlySales', 'yearlySales'));
    }

    public function list()
    {
        return view('admin.manage-admin.list');
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.manage-admin.create',compact('roles'));
    }

    public function store(Request $request){

        $data =$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'regex:/^09[0-9]{9}$/', 'unique:users,mobile'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name'],
            'password' => ['required', 'string', 'min:4', 'same:repassword'],
            'repassword' => ['required', 'string'],
        ], [
            'name.required' => 'نام الزامی است.',
            'name.string' => 'نام باید متن باشد.',
            'name.max' => 'نام نباید بیشتر از ۲۵۵ کاراکتر باشد.',
            'roles.required' => ' نقش‌ کاربر اجباری هست.',
            'roles.array' => 'فرمت نقش‌ها نامعتبر است.',
            'roles.*.exists' => 'نقش انتخاب شده در سیستم وجود ندارد.',
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.string' => 'شماره موبایل باید متن باشد.',
            'mobile.regex' => 'فرمت شماره موبایل صحیح نیست. (مثال: ۰۹۱۲۳۴۵۶۷۸۹)',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است.',

            'type.required' => 'نوع کاربر الزامی است.',
            'type.enum' => 'نوع کاربر انتخاب شده معتبر نیست.',

            'password.required' => 'رمز عبور الزامی است.',
            'password.string' => 'رمز عبور باید متن باشد.',
            'password.min' => 'رمز عبور باید حداقل 4 کاراکتر باشد.',
            'password.same' => 'رمز عبور و تکرار رمز عبور مطابقت ندارند.',

            'repassword.required' => 'تکرار رمز عبور الزامی است.',
            'repassword.string' => 'تکرار رمز عبور باید متن باشد.',
        ]);

        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $data['password'] = Hash::make($data['password']);

        $user = User::query()->create($data);


        if (!empty($roles)) {
            $user->assignRole($roles);
        }

        return redirect()->route('admin.list')
            ->with('success', 'کاربر با موفقیت ایجاد شد');
    }

    public function edit(User $user)
    {
        $roles = Role::all();


        $userRoles = $user->roles->pluck('name')->toArray();

        return view('admin.manage-admin.edit', compact(
            'user',
            'roles',
            'userRoles'
        ));
    }
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'mobile' => [
                'required',
                'string',
                'regex:/^09[0-9]{9}$/',
                'unique:users,mobile,' . $user->id,
            ],

            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name'],

            'password' => ['nullable', 'string', 'min:4', 'same:repassword'],
            'repassword' => ['nullable', 'string'],
        ], [
            'name.required' => 'نام الزامی است.',
            'name.string' => 'نام باید متن باشد.',
            'name.max' => 'نام نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.string' => 'شماره موبایل باید متن باشد.',
            'mobile.regex' => 'فرمت شماره موبایل صحیح نیست. (مثال: ۰۹۱۲۳۴۵۶۷۸۹)',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است.',

            'roles.required' => 'نقش کاربر اجباری است.',
            'roles.array' => 'فرمت نقش‌ها نامعتبر است.',
            'roles.*.exists' => 'نقش انتخاب شده در سیستم وجود ندارد.',

            'password.string' => 'رمز عبور باید متن باشد.',
            'password.min' => 'رمز عبور باید حداقل ۴ کاراکتر باشد.',
            'password.same' => 'رمز عبور و تکرار رمز عبور مطابقت ندارند.',

            'repassword.string' => 'تکرار رمز عبور باید متن باشد.',
        ]);


        $user->name = $data['name'];
        $user->mobile = $data['mobile'];


        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();


        $user->syncRoles($data['roles']);

        return redirect()
            ->route('admin.list')
            ->with('success', 'اطلاعات کاربر با موفقیت ویرایش شد.');
    }

    public function delete(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'نمی‌توانید خودتان را حذف کنید.');
        }
        $user->update([
            'mobile' => $user->mobile . '_deleted_' . $user->id,
        ]);

        $user->delete();

        return back()->with('success', 'ادمین با موفقیت حذف شد.');
    }

    public function changeStatus(User $user)
    {
        if ($user->is_active){
            $user->update(['is_active' => false]);
        }else{
            $user->update(['is_active' => true]);
        }
        return back()->with('success','وضعیت کاربر با موفقیت تغییر کرد.');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));

    }
    public function paymentGatewayForm()
    {
        $gateway=PaymentGateway::first();
        return view('admin.payment-gateway',compact('gateway'));
    }

    public function paymentGatewayUpdate(PaymentGateway $gateway, Request $request)
    {
        $data=$request->validate([
            'is_active'=>'boolean',
        ]);
        $gateway->update($data);

        return back()->with('success', ' درگاه با موفقیت بروز شد.');

    }
}
