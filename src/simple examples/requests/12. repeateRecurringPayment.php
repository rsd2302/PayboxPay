<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';
$paybox->order->description = 'test order';
$paybox->order->recurringProfile = 1234;

$result = $paybox->makePayment();
