<?php

return [
    'api_key' => env('SMS_IR_API_KEY', ''),

    'templates' => [
        'verify_code' => env('SMS_TEMPLATE_VERIFY_CODE', ''),

    ],
];
