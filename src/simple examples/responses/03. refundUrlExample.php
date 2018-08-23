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
//[pg_amount]
//[pg_currency]
//[pg_net_amount]
//[pg_ps_full_amount]
//[pg_ps_currency]
//[pg_payment_system]
//[pg_refund_date]
//[pg_refund_type]
//[pg_refund_system]
//[pg_refund_id]
//[pg_salt]
//[pg_sig]

if($paybox->checkSig($request)) {
    //Here You must register event. For example, update a order total amount, then send response
    echo $this->refunded();
}
