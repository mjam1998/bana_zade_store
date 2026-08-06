<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SendMethod;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use TCPDF;
use TCPDF_FONTS;

class AdminOrderController extends Controller
{
    public function index(){
        return view('admin.order.index');
    }

    public function show(Order $order){

        $order->load([
            'orderItems.product' => fn($q) => $q->withTrashed(),
            'sendMethod'=> fn($q) => $q->withTrashed()
        ]);
        $sendMethods = SendMethod::all();

        return view('admin.order.show', compact('order', 'sendMethods'));
    }
    public function update(Request $request, Order $order)
    {

        $validated = $request->validate([
            'status' => 'required|integer|in:0,1,2',
            'send_method_id' => 'nullable|exists:send_methods,id',
            'track_number' => 'nullable|string|max:255|unique:orders,track_number,' . $order->id,
            'send_at' => 'nullable|string',
        ], [
            'status.required' => 'وضعیت سفارش الزامی است',
            'status.integer' => 'وضعیت باید عدد باشد',
            'status.in' => 'وضعیت انتخاب شده نامعتبر است',
            'send_method_id.exists' => 'روش ارسال انتخاب شده معتبر نیست',
            'track_number.string' => 'کد پیگیری باید متن باشد',
            'track_number.max' => 'کد پیگیری نباید بیشتر از 255 کاراکتر باشد',
            'track_number.unique' => 'این کد پیگیری قبلا استفاده شده است',
            'send_at.string' => 'فرمت تاریخ ارسال نامعتبر است',
        ]);

        try {
            $data = [
                'status' => $validated['status'],
                'send_method_id' => $validated['send_method_id'],
                'track_number' => $validated['track_number'],
            ];

            if (!empty($validated['send_at'])) {

                $gregorianDate = \Morilog\Jalali\Jalalian::fromFormat('Y/n/j', $validated['send_at'])
                    ->toCarbon();
                $data['send_at'] = $gregorianDate;
            }

            $order->update($data);

            return back()
                ->with('success', 'سفارش با موفقیت به‌روزرسانی شد');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'خطا در به‌روزرسانی سفارش: ' . $e->getMessage())
                ->withInput();
        }
    }

    // در OrderController.php

    // app/Http/Controllers/Admin/OrderController.php



    public function downloadInvoicePdf($id)
    {
        $order = Order::with(['orderItems.product', 'orderItems.subProduct', 'sendMethod'])
            ->findOrFail($id);

        // ایجاد نمونه TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // تنظیمات PDF
        $pdf->SetCreator('فروشگاه');
        $pdf->SetAuthor(config('app.name'));
        $pdf->SetTitle('فاکتور سفارش #' . $order->code);
        $pdf->SetSubject('فاکتور');

        // حذف هدر و فوتر پیش‌فرض
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // **تنظیم RTL برای راست‌چین**
        $pdf->setRTL(true);

        // تنظیم فونت فارسی
//        $pdf->SetFont('dejavusans', '', 10);
        $fontPath = storage_path('fonts/tcpdf/');
        $fontRegular = TCPDF_FONTS::addTTFfont($fontPath . 'Vazirmatn-Regular.ttf', 'TrueTypeUnicode', '', 96);
        $fontBold = TCPDF_FONTS::addTTFfont($fontPath . 'Vazirmatn-Bold.ttf', 'TrueTypeUnicode', '', 96);
//        $pdf->SetFont($fontRegular, '', 10);
        // تنظیم حاشیه
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 15);

        // افزودن صفحه
        $pdf->AddPage();

        // محتوای HTML
        $html = $this->generateInvoiceHtml($order);

        // نوشتن HTML در PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // خروجی PDF
        return $pdf->Output('invoice_' . $order->code . '.pdf', 'D');
    }

    private function generateInvoiceHtml($order)
    {
        $order->load([
            'orderItems.product' => fn($q) => $q->withTrashed(),
            'orderItems.subProduct' => fn($q) => $q->withTrashed(),
        ]);
        $html = '
<style>
    * { font-family: dejavusans; }
    body { direction: rtl; text-align: right; }

    .header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #333;
        padding-bottom: 15px;
    }
    .header h1 { font-size: 20px; margin: 10px 0; }
    .header p { font-size: 11px; margin: 5px 0; }

    .info-section { margin: 15px 0; }
    .info-section h3 {
        background-color: #f5f5f5;
        padding: 8px;
        font-size: 13px;
        border-right: 4px solid #333;
        text-align: right;
    }
    .info-row {
        padding: 5px 10px;
        font-size: 11px;
        text-align: right;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
    }
    table th {
        background-color: #333;
        color: #fff;
        padding: 8px;
        text-align: center;
        font-size: 11px;
    }
    table td {
        border: 1px solid #ddd;
        padding: 6px;
        text-align: center;
        font-size: 10px;
    }
    table tr:nth-child(even) { background-color: #f9f9f9; }

    .total-section {
        margin: 15px 0;
        padding: 12px;
        background-color: #f5f5f5;
        border: 2px solid #333;
        text-align: right;
    }
    .total-row {
        padding: 6px 0;
        font-size: 12px;
        text-align: right;
    }

    .payment-box {
        background-color: #0066cc;
        color: #fff;
        padding: 12px;
        text-align: center;
        margin: 15px 0;
    }
    .payment-box h2 { font-size: 16px; margin: 0; }

    .footer {
        margin-top: 25px;
        padding-top: 12px;
        border-top: 1px solid #ddd;
        text-align: center;
        font-size: 9px;
        color: #666;
    }
</style>

<div class="header">
    <h1>فاکتور فروش</h1>
    <p><strong>فروشگاه آقای صفر تا صد</strong></p>
    <p><strong>www.aghaye0ta100.ir</strong></p>
     <p><strong>دفتر مرکزی: اصفهان، خیابان بابک نبش کوچه ۲۳</strong></p>
    <p>تلفن: 09136437210</p>
</div>

<div class="info-section">
    <h3>اطلاعات سفارش</h3>
    <div class="info-row"><strong>شماره سفارش:</strong> ' . $order->code . '</div>
    <div class="info-row"><strong>تاریخ ثبت:</strong> ' . \Morilog\Jalali\Jalalian::fromDateTime($order->created_at)->format('Y/m/d H:i') . '</div>
    <div class="info-row"><strong>شماره فاکتور:</strong> ' . $order->code . '</div>
</div>

<div class="info-section">
    <h3>اطلاعات مشتری</h3>
    <div class="info-row"><strong>نام:</strong> ' . $order->name . '</div>
    <div class="info-row"><strong>موبایل:</strong> ' . $order->mobile . '</div>
    <div class="info-row"><strong>استان:</strong> ' . $order->state . '</div>
    <div class="info-row"><strong>شهر:</strong> ' . $order->city . '</div>
    <div class="info-row"><strong>کد پستی:</strong> ' . $order->postal_code . '</div>
</div>

<div class="info-section">
    <h3>اطلاعات ارسال و پرداخت</h3>
    <div class="info-row"><strong>روش ارسال:</strong> ' . $order->sendMethod->name . '</div>
    <div class="info-row"><strong>آدرس:</strong> ' . $order->address . '</div>
     <div class="info-row">تاریخ ارسال: ' . \Morilog\Jalali\Jalalian::fromDateTime($order->send_at)->format('Y/m/d') . '</div>
     <div class="info-row"><strong>کد پیگیری روش ارسال:</strong> ' . $order->track_number . '</div>
</div>

<div class="info-section">
    <h3>محصولات سفارش</h3>
    <table>
        <thead>
            <tr>
                <th>ردیف</th>
                <th>نام محصول</th>
                <th>قیمت واحد</th>
                <th>تخفیف</th>
                <th>تعداد</th>
                <th>قیمت نهایی</th>
            </tr>
        </thead>
        <tbody>';

        $row = 1;
        foreach ($order->orderItems as $item) {



                $productName = $item->product->name;

                // بررسی زیرمحصول
                if ($item->product->has_sub_product && $item->subProduct) {
                    $productName .= ' - ' . $item->subProduct->name;
                }


            $html .= '
        <tr>
            <td>' . $row++ . '</td>
            <td>' . $productName . '</td>
               <td><span style="direction: ltr; display: inline-block;">' . number_format($item->price) . '</span> تومان</td>

            <td><span style="direction: ltr; display: inline-block;">' . number_format($item->discount) . '</span> تومان</td>
            <td>' . $item->quantity . '</td>
             <td><span style="direction: ltr; display: inline-block;">' .  number_format(($item->price * $item->quantity )-$item->discount) . '</span> تومان</td>
        </tr>';
        }

        $html .= '
        </tbody>
    </table>
</div>

<div class="total-section">
    <div class="total-row">جمع کل: <strong style="direction: ltr; display: inline-block;">' . number_format($order->total_amount) . '</strong> <strong>تومان</strong> </div>
</div>

<div class="payment-box">
    <h2>مبلغ قابل پرداخت: ' . number_format($order->pay_amount) . ' تومان</h2>
</div>

<div class="footer">
    <p>این فاکتور به صورت الکترونیک صادر شده و نیازی به امضا و مهر ندارد.</p>
    <p>تاریخ چاپ: ' . \Morilog\Jalali\Jalalian::now()->format('Y/m/d H:i') . '</p>
</div>';

        return $html;
    }





}
