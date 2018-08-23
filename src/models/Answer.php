<?php

/*
 * This file is part of the Pay package in (c)Paybox Integration Component.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Paybox\Pay\Models;

use Paybox\Core\Abstractions\Answer as CoreAnswer;

/**
 *
 * @see Paybox\Core\Abstractions\Answer
 *
 * @package Paybox\Pay\Models
 * @version 1.2.2
 * @author Sergey Astapenko <sa@paybox.money> @link https://paybox.money
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * @property-write string $status
 *
 * @method setStatus(string $status):bool
 * @method setTimeout(int $timeout):bool
 * @method setDescription(string $description):bool
 *
 */

final class Answer extends CoreAnswer {

    /**
     * @var int $timeout Must be used for set lifetime of payment
     */
    public $timeout;

    /**
     * @var string $description Must be used for set description of order
     */
    public $description;

}
