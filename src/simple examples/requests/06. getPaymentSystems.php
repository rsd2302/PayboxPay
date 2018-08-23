<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

//set required properties

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';
$paybox->order->amount = 100;

$paymentSystems = $paybox->getPaymentSystems();
