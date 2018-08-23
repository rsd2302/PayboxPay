<?php

use Paybox\Pay\Facade as Paybox;

$paybox = new Paybox();

//set required properties

$paybox->getMerchant()
    ->setId(123456)
    ->setSecretKey('asflerjgsdfv');

$paybox->getPayment()
    ->setId(11044111);

$status = $paybox->getStatus(); //new/ok/revoked/failed/incomplete

