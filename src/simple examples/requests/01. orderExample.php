<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

//set required properties as you wish
//using properties
$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';
$paybox->order->description = 'test order';
$paybox->order->amount = 100;

//or using getters and setters

$paybox->getMerchant()->setId(123456);
$paybox->getMerchant()->setSecretKey('asflerjgsdfv');
$paybox->getOrder()->setAmount(100);
$paybox->getOrder()->setDescription('test order');

//or somehow differently

$merchant = $paybox->getMerchant();
$merchant->setId(123456);
$merchant->setSecretKey('asflerjgsdfv');

$order = $paybox->getOrder();
$order->setAmount(100);
$order->setDescription('test order');

if($paybox->init()) {
    header('Location:' . $paybox->redirectUrl);
}
