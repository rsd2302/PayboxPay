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
//[pg_payment_id] => 10057654
//[pg_amount] => 100.00
//[pg_currency] => KZT
//[pg_net_amount] => 95
//[pg_ps_amount] => 100
//[pg_ps_full_amount] => 100
//[pg_ps_currency] => KZT
//[pg_payment_system] => EPAYWEBKZT
//[pg_description] => test order
//[pg_result] => 1
//[pg_payment_date] => 2018-05-23 03:25:14
//[pg_can_reject] => 1
//[pg_user_phone] => 77777777777
//[pg_need_phone_notification] => 0
//[pg_user_contact_email] => test@g.com
//[pg_need_email_notification] => 0
//[pg_testing_mode] => 0
//[pg_captured] => 0
//[pg_card_pan] => 4405-64XX-XXXX-6150
//[pg_card_exp] => 09/25
//[pg_card_owner] => TEST
//[pg_card_brand] => VI
//[pg_salt] => YQyk545ZL1lYyNeX
//[pg_sig] => efdd67eea31db705ed48812840d71b5

if($paybox->checkSig($request)) {
    //You must use this to notify Paybox the successful receipt of payment
    echo $paybox->accept('Ok. Order will be prepared');
    //or
    if($request['pg_can_reject'] == 1) { //if payment can be reject/revert
        echo $paybox->cancel('Order was cancelled by phone'); // You can cancel payment
    }
}
