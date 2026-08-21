<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $apiKey;
    protected string $endpoint = 'https://api.sms.ir/v1/send/verify';

    public function __construct()
    {
        $this->apiKey = config('sms.api_key');
    }

    /**
     * ارسال پیامک با پترن (Verify Template)
     *
     * @param string $mobile شماره موبایل گیرنده
     * @param int $templateId شناسه پترن در پنل sms.ir
     * @param array $parameters آرایه انجمنی مثل ['NAME' => 'علی', 'CODE' => 12345]
     */
    public function send(string $mobile, int $templateId, array $parameters = []): void
    {

        try {
            Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'text/plain',
                'x-api-key' => $this->apiKey,
            ])->post($this->endpoint, [
                'mobile' => $mobile,
                'templateId' => $templateId,
                'parameters' => $this->buildParameters($parameters),
            ]);
        }
       catch (\Exception $e) {
            Log::error($e->getMessage());
       }

    }

    protected function buildParameters(array $parameters): array
    {
        $result = [];
        foreach ($parameters as $name => $value) {
            $result[] = ['name' => $name, 'value' => $value];
        }
        return $result;
    }

    /**
     * ارسال کد تایید (برای ثبتنام / فراموشی رمز)
     */
    public function sendVerificationCode(string $mobile, int $code,string $name): void
    {
         $this->send(
            mobile: $mobile,
            templateId: (int) config('sms.templates.verify_code'),
            parameters: ['CODE' => $code,'NAME' => $name],
        );
    }

    /**
     * تولید کد تصادفی ۵ رقمی
     */
    public function generateCode(): int
    {
        return random_int(10000, 99999);
    }
}
