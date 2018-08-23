<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

//set required properties

$paybox->getMerchant()
    ->setId(123456)
    ->setSecretKey('asflerjgsdfv');

$paybox->getPayment()
    ->setId(11044111);

//if you need to revoke a part of payment, You must use the "revoke" method with a argument
$result = $paybox->revoke(100);
//OR
//if no artuments, whole the payment was be revoked
$result = $paybox->revoke();
