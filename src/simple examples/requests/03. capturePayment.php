<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';

//If You have a ID of payment and it status is success
//You can initialize the clearing operation using capture() method
$paybox->payment->id = 12345;
$result = $paybox->capture();
