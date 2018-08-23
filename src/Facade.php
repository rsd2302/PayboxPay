<?php

/*
 * This file is part of the Pay package in (c)Paybox Integration Component.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Paybox\Pay;

use Paybox\Core\ {
    Exceptions\Property as PropertyException,
    Exceptions\Connection as ConnectionException,
    Exceptions\Request as RequestException,
    Abstractions\DataContainer,
    Interfaces\Pay as PaymentInterface
};

/**
 * Facade of Paybox\Pay classes
 * Simple facade for comfortable using a whole Paybox Pay functionality
 *
 * @package Paybox\Pay
 * @version 1.2.2
 * @author Sergey Astapenko <sa@paybox.money> @link https://paybox.money
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * @property Paybox\Pay\Models\Answer $answer
 * @property Paybox\Pay\Models\Config $config
 * @property Paybox\Pay\Models\Customer $customer
 * @property Paybox\Pay\Models\Merchant $merchant
 * @property Paybox\Pay\Models\Order $order
 * @property Paybox\Pay\Models\Payment $payment
 *
 */

class Facade extends DataContainer implements PaymentInterface {

    /**
     * @var url $redurectUrl for saving link to payment page
     */
    public $redirectUrl;

    /**
     * @var url $url
     */
    public $url;

    /**
     *
     * This method initialize a payment
     *
     * Method get all required params, check filling and send request to Paybox
     *
     * @return bool|Exception TRUE if initialize of payment is success
     *
     */

    public function init():bool {
        try {
            $this->order->required('amount');
            $this->order->required('description');
            $this->save('init_payment');
            $this->send();
            $this->redirectUrl = $this->getServerAnswer('redirect_url');
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     *
     * This method initialize a recurrent profile of payment
     *
     * @see Facade::init()
     *
     */

    public function recurringStart(int $lifetime):bool {
        try {
            $this->config->isRecurringStart = true;
            $this->config->recurringLifetime = $lifetime;
            return $this->init();
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     *
     * This method init a payment using recurrent profile
     *
     * @see Facade::recurringStart()
     *
     */

    public function makePayment() {
        try {
            $this->order->required('recurringProfile');
            $this->order->required('description');
            $this->save('make_recurring_payment');
            $this->send();
            return $this->getServerAnswer('status');
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * This method send request to paybox, for getting a status of payment or order
     *
     * If You use orderId for getStatus(), possible answers is:
     *   partial | pending | ok | failed | revoked | incomplete
     *
     * If You use getStatus() with paymentId, You can get one of statuses:
     *   new | ok | revoked | failed | incomplete
     *
     * @return string | Exception
     *
     */

    public function getStatus():string {//paymentId or OrderId
        try {
            $this->save('get_status');
            $this->send();
            return $this->getServerAnswer('transaction_status');
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * This method cancel payment or revert a part of payment
     *
     * @param int $amount
     *
     * @return string | Exception
     *
     */

    public function revoke(int $amount = 0):string {
        try {
            $this->payment->refundAmount = $amount;
            $this->save('revoke');
            $this->send();
            return $this->getServerAnswer('transaction_status');
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return false;
        }

    }

    /**
     * This method create a refund request if payment can't be canceled
     *
     * @param string $comment Description of refund reason
     * @param int $amount
     *
     * @return string | Exception
     */

    public function refund(string $comment, int $amount = 0):string {
        try {
            $this->required('comment');
            $this->payment->refundAmount = $amount;
            $this->save('create_refund_request');
            $this->send();
            return $this->getServerAnswer('status');
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     *
     * Method init a clearing operation
     *
     * @return string
     *
     */

    public function capture():string {
        try {
            $this->payment->required('id');
            $this->save('do_capture');
            $this->send();
            return $this->getServerAnswer('status');
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     *
     * Method return a array with Payment Systems allowed for You
     *
     * @return array | Exception
     */

    public function getPaymentSystems():array {
        try {
            $this->order->required('amount');
            $this->save('ps_list');
            $this->send();
            return $this->getServerArrayAnswer('payment_system');
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    /**
     *
     * Method send request to Paybox for cancel a bill before it be paid. Only for email bills
     *
     * @return string
     */

    public function cancelBill():string {
        try {
            $this->payment->required('id');
            $this->save('cancel');
            $this->send();
            return $this->getServerAnswer('status');
        } catch(PropertyException | ConnectionException | RequestException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Use it for answer on Your resultUrl (@see Pay\Models\Config::$resultUrl)
     *  if Paybox must try connecting later (after 30 min)
     *
     * @param string $errorDescription
     *
     * @return XML formatted answer for Paybox
     *
     */

    public function error(string $errorDescription) {
        header('Content-Type: application/xml', true, 500);
        $this->answer->status = 'error';
        $this->answer->errorDescription = $errorDescription;
        $this->answer->timeout = $waitingTimer;
        $this->save();
        return $this->answer();
    }

    /**
     *
     * Use it for answer on Your resultUrl (@see Pay\Models\Config::$resultUrl)
     * if You accept a payment and can complete order
     *
     * @param string $successMessage
     *
     * @return XML formatted answer for Paybox
     *
     */

    public function accept(string $successMessage) {
        header('Content-Type: application/xml', true, 200);
        $this->answer->status = 'ok';
        $this->answer->description = $successMessage;
        $this->save();
        return $this->answer();
    }

    /**
     *
     * Use it for answer on Your checkUrl (@see Pay\Models\Config::$checkUrl)
     *  if You need a pay of order
     * @param int $waitingTimer How long you can wait a pay (in seconds)
     *
     * @return XML formatted answer for Paybox
     *
     */

    public function waiting(int $waitingTimer) {
        header('Content-Type: application/xml', true, 200);
        $this->answer->status = 'ok';
        $this->answer->timeout = $waitingTimer;
        $this->save();
        return $this->answer();
    }

    /**
     *
     * Use it for answer on Your checkUrl/resultUrl
     * if You want to cancel payment
     *
     * @param string $cancelDescription
     *
     * @return XML formatted answer for Paybox
     *
     */

    public function cancel(string $cancelDescription) {
        header('Content-Type: application/xml', true, 200);
        $this->answer->status = 'rejected';
        $this->answer->description = $cancelDescription;
        $this->save();
        return $this->answer();
    }

    /**
     *
     * Use it for answer on Your refundUrl (@see Pay\Models\Config::$refundUrl)
     *
     * @return XML formatted answer for Paybox
     *
     */

    public function refunded() {
        header('Content-Type: application/xml', true, 200);
        $this->answer->status = 'ok';
        $this->save();
        return $this->answer();
    }

    /**
     *
     * Use it for answer on Your captureUrl (@see Pay\Models\Config::$captureUrl)
     *
     * @return XML formatted answer for Paybox
     *
     */

    public function captured() {
        header('Content-Type: application/xml', true, 200);
        $this->answer->status = 'ok';
        $this->save();
        return $this->answer();
    }

    /**
     *
     * Parse a request from Paybox and return it as array
     *
     * @param XML $request
     *
     * @return array
     */

    public function parseXML($request):array {
        return (array) (new \SimpleXMLElement($request['pg_xml']));
    }

    /**
     *
     * Get a url of Payment gate
     *
     * @return string
     *
     */

    protected function getBaseUrl():string {
        return 'https://api.paybox.money/';
    }

    /**
     * This method convert Your answers to XML
     *
     * @return XML
     *
     */

    private function answer() {
        $this->toXML();
        return $this->xml->asXML();
    }

}
