<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

//set required properties

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';
$paybox->order->id = 2;

$paymentStatus = $paybox->getStatus(); //partial/pending/ok/failed/revoked/incomplete
