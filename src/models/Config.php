<?php

/*
 * This file is part of the Pay package in (c)Paybox Integration Component.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Paybox\Pay\Models;

use Paybox\Core\Abstractions\Config as CoreConfig;

/**
 * @see Paybox\Core\Abstractions\Config
 *
 * @package Paybox\Pay\Models
 * @version 1.2.2
 * @author Sergey Astapenko <sa@paybox.money> @link https://paybox.money
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * @property string $currency
 * @property-write string $paymentSystem
 * @property string $encoding
 *
 * @method setCurencty(string $currency):bool
 * @method getCurrency():string
 * @method setPaymentSystem(string $paymentSystem):bool
 * @method setEncoding(string $charset):bool
 * @method getEncoding():string
 * @method setCheckUrl(string $url):bool
 * @method setResultUrl(string $url):bool
 * @method setRefundUrl(string $url):bool
 * @method setCaptureUrl(string $url):bool
 * @method setSuccessUrl(string $url):bool
 * @method setSuccessUrlMethod(string $method):bool
 * @method getSuccessUrlMethod():string
 * @method setFailureUrl(string $url):bool
 * @method setFailureUrlMethod(string $method):bool
 * @method getFailureUrlMethod():string
 * @method setStateUrl(string $url):bool
 * @method setStateUrlMethod(string $method):bool
 * @method getStateUrlMethod():string
 * @method setSiteUrl(string $url):bool
 * @method setRequestMethod(string $method):bool
 * @method getRequestMethod():string
 * @method setLifetime(int $seconds):bool
 * @method setRecurringLifetime(int $monthes):bool
 * @method setIsPostponePayment(bool $value):bool
 * @method setIsRecurringStart(bool $value):bool
 * @method setIsTestingMode(bool $value):bool
 *
 */

final class Config extends CoreConfig {

    /**
     * @var url $checkUrl Optional property. It must be a link on real url of Your website
     * Set value, if Paybox must request the order status before accepting payment
     */
    public $checkUrl;

    /**
     * @var url $resultUrl Optional property. It must be a link on real url of Your website
     * Set value, if Paybox must send a payment result to Your website
     */
    public $resultUrl;

    /**
     * @var url $refundUrl Optional property. It must be a link on real url of Your website
     * Set value, if Paybox must send a result of refund/revert operation to Your website.
     */
    public $refundUrl;

    /**
     * @var url $captureUrl Optional property. It must be a link on real url of Your website
     * Set value, if Paybox must send a result of clearing operation to Your website
     */
    public $captureUrl;

    /**
     * @var url $successUrl Optional property. It must be a link on real url of Your website
     * This url will be use when order is success paid, for redirecting a customer
     */
    public $successUrl;

    /**
     * @var url $failure Optional property. It must be a link on real url of Your website
     * This url will be use when payment get error, for redirecting a customer
     */
    public $failureUrl;

    /**
     * @var url $stateUrl Optional property. It must be a link on real url of Your website
     * This url for user redirect to wait for payment status
     */
    public $stateUrl;

    /**
     * @var url $siteUrl Optional property.
     * Url of Your website
     */
    public $siteUrl;

    /**
     * @var int $lifetime Optional property. Order lifetime (in seconds)
     */
    public $lifetime;

    /**
     * @var int $recurringLifetime Required fot init recurrent payment
     * Lifetime of recurrent profile (in monthes) @see $isRecurringStart
     */
    public $recurringLifetime;

    /**
     * @var string $stateUrlMethod Optional.
     * This property specifies how the $stateUrl will be called (POST/GET/XML)
     */
    public $stateUrlMethod = 'POST';

    /**
     * @var string $requestMethod Optional.
     * This property defines how Paybox can access your site
     */
    public $requestMethod = 'POST';

    /**
     * @var string $successUrlMethod Optional.
     * This property defines how Paybox can access your $successUrl @see $successUrl
     */
    public $successUrlMethod = 'POST';

    /**
     * @var string $failureUrlMethod Optional.
     * This property defines how Paybox can access your $failureUrl @see $failureUrl
     */
    public $failureUrlMethod = 'POST';

    /**
     * @var bool $isPostponePayment Optional.
     * If is TRUE, customer will see a page with instructions and get a email with link for payment
     */
    public $isPostponePayment;

    /**
     * @var bool $isRecurringStart Optional.
     * If is TRUE, will be create a recurrent profile of payment and You can call profile for repeat a payment.
     */
    public $isRecurringStart;

    /**
     * @var bool $isTestingMode Optional.
     * If is TRUE, Your payment will be marked as 'testing' and You can use it for testing a payment systems
     */
    public $isTestingMode;
    
    /**
     * @var string $paymentRoute Optional.
     * If is "frame", payment form can be opened as frame
     */
    public $paymentRoute;
}
