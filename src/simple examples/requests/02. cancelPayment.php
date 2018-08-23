<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';
$paybox->payment->id = 1234;

//if payment can't be cancelled using check_url or result_url (pg_can_reject == 0)
//You can use this request for refund all payment
$result = $paybox->refund('Customer changed his mind');

//or refund a part of payment, indicating the amount for refund
$result = $paybox->refund('Customer cancel a part of order', 100);
