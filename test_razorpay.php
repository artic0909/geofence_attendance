<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Razorpay\Api\Api;
$api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
try {
    $order = $api->order->create([
        'receipt'         => 'order_rcptid_' . time(),
        'amount'          => 200, // amount in paise
        'currency'        => 'INR',
        'payment_capture' => 1 // auto capture
    ]);
    print_r($order);
} catch (\Exception $e) {
    echo "Razorpay Error: " . $e->getMessage() . "\n";
}
