<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';
$paybox->order->description = 'test order';
$paybox->order->amount = 100;

$recurrentProfileLifetime = 12 //min = 1 month, max 156 monthes

if($paybox->recurringStart($recurrentProfileLifetime)) {
    header('Location:' . $paybox->redirectUrl);
}
