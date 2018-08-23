<?php

require 'autoload.php';
use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';

$request = (array_key_exists('pg_xml', $_REQUEST))
    ? $paybox->parseXML($_REQUEST)
    : $_REQUEST;

//example of $request
//[pg_order_id]
//[pg_payment_id]
//[pg_salt]
//[pg_sig]

if($paybox->checkSig($request)) {
    echo $this->captured();
}
