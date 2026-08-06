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

class AdminController extends Controller
{
    public function index(){
        // در Controller یا Route
        $stats = [
            'products'      => Product::count(),
            'categories'    => Category::count(),
            'orders'        => Order::count(),
            'waiting_send'  => Order::where('status', \App\Enums\OrderStatus::WaitingSend)->count(),
            'sent'          => Order::where('status', \App\Enums\OrderStatus::Sent)->count(),
        ];

        return view('admin.index',compact('stats'));
    }

    public function list()
    {
        return view('admin.manage-admin.list');
    }

    public function create()
    {
        $userTypes=UserType::cases();
        return view('admin.manage-admin.create',compact('userTypes'));
    }

    public function store(Request $request){

        $data =$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'regex:/^09[0-9]{9}$/', 'unique:users,mobile'],
            'type' => ['required', Rule::enum(UserType::class)],
            'password' => ['required', 'string', 'min:4', 'same:repassword'],
            'repassword' => ['required', 'string'],
        ], [
            'name.required' => 'نام الزامی است.',
            'name.string' => 'نام باید متن باشد.',
            'name.max' => 'نام نباید بیشتر از ۲۵۵ کاراکتر باشد.',

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

        $data['password'] = Hash::make($data['password']);

        $user=User::query()->create($data);
        if ($user->type==UserType::Primary){
            User::where('type', UserType::Primary)->where('id','!=',$user->id)->update(['type' => UserType::Regular]);
        }

        return redirect()->route('admin.list')
            ->with('success', 'ادمین با موفقیت ایجاد شد');
    }

    public function edit(User $user){
        $userTypes=UserType::cases();
        return view('admin.manage-admin.edit',compact('userTypes','user'));
    }
    public function update(Request $request, User $user)
    {
        if ($user->type == UserType::Primary && $request->type != UserType::Primary->value) {

            $primaryCount = User::where('type', UserType::Primary)->count();

            if ($primaryCount <= 1) {
                return back()->withInput()->with('error', 'حداقل یک ادمین گیرنده پیامک باید وجود داشته باشد.');
            }
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => [
                'required',
                'string',
                'regex:/^09[0-9]{9}$/',
                Rule::unique('users', 'mobile')->ignore($user->id)
            ],
            'type' => ['required', Rule::in(array_column(UserType::cases(), 'value'))],
            'password' => ['nullable', 'string', 'min:4', 'same:repassword'],
            'repassword' => ['nullable', 'string'],
        ], [
            'name.required' => 'نام الزامی است.',
            'name.string' => 'نام باید متن باشد.',
            'name.max' => 'نام نباید بیشتر از 255 کاراکتر باشد.',

            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.string' => 'شماره موبایل باید متن باشد.',
            'mobile.regex' => 'فرمت شماره موبایل صحیح نیست. (مثال: 09123456789)',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است.',

            'type.required' => 'نوع کاربر الزامی است.',
            'type.in' => 'نوع کاربر انتخاب شده معتبر نیست.',

            'password.string' => 'رمز عبور باید متن باشد.',
            'password.min' => 'رمز عبور باید حداقل 4 کاراکتر باشد.',
            'password.same' => 'رمز عبور و تکرار آن یکسان نیستند.',

            'repassword.string' => 'تکرار رمز عبور باید متن باشد.',
        ]);

        $user->name = $validated['name'];
        $user->mobile = $validated['mobile'];
        $user->type = UserType::from($validated['type']);


        // فقط در صورت وارد کردن رمز عبور جدید، آن را تغییر دهید
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($user->type==UserType::Primary){
            User::where('type', UserType::Primary)->where('id','!=',$user->id)->update(['type' => UserType::Regular]);
        }

        return redirect()->route('admin.list')->with('success', 'ادمین با موفقیت ویرایش شد.');
    }

    public function delete(User $user){
        if ($user === auth()->user()){
            return back()->with('error','نمیتوانید خودتان را حذف کنید');
        }


        if ($user->type == UserType::Primary) {

            $primaryCount = User::where('type', UserType::Primary)->count();

            if ($primaryCount <= 1) {
                return back()->with('error', 'حداقل یک ادمین گیرنده پیامک باید در سایت باقی بماند.');
            }
        }


        $user->delete();
        return back()->with('success', 'ادمین با موفقیت حذف شد.');
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
