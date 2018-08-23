<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';

$request = (array_key_exists('pg_xml', $_REQUEST))
    ? $paybox->parseXML($_REQUEST)
    : $_REQUEST;

$comment = 'Return a part of order amount';
$amount = 500;
$result = $paybox->refund($comment, $amount);

