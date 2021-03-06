<?php

/*
 * This file is part of the Pay package in (c)Paybox Integration Component.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Paybox\Pay;

use SimpleXMLElement;
use Paybox\Core\Interfaces\Pay as PaymentInterface;
use Paybox\Core\Exceptions\Request as RequestException;

class NewFacade extends Facade implements PaymentInterface {

    public $serverResponse;

    public function getProtected($property)
    {
        return $this->{'get'.$property}();
    }

    // protected function getBaseUrl():string
    // {
    //     return 'http://paybox.core.loc/';
    // }

    public function getProtectedServerAnswer()
    {
        return $this->serverAnswer;
    }

    /**
     * Send requests to Paybox and get answer
     *
     * @return void
     */

    protected function send():void {
        if($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $this->getBaseUrl().$this->url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->query);
            $this->serverResponse = curl_exec($curl);
            $xml = new SimpleXMLElement($this->serverResponse);
            curl_close($curl);
            if($xml->xpath('//pg_error_code')) {
                throw new RequestException($xml->xpath('//pg_error_code')[0]
                    . ':' .
                    $xml->xpath('//pg_error_description')[0]
                    . PHP_EOL
                );
            } else {
                $this->serverAnswer = (array) $xml;
            }
        }
    }
}
