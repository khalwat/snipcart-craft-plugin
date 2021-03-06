<?php
/**
 * Snipcart plugin for Craft CMS 3.x
 *
 * @link      https://workingconcept.com
 * @copyright Copyright (c) 2018 Working Concept Inc.
 */

namespace workingconcept\snipcart\models;

/**
 * Class Subscription
 * https://docs.snipcart.com/api-reference/subscriptions
 * @package workingconcept\snipcart\models
 */
class Subscription extends \craft\base\Model
{
    // Constants
    // =========================================================================

    const STATUS_ACTIVE   = 'Active';
    const STATUS_PAUSED   = 'Paused';
    const STATUS_CANCELED = 'Canceled';


    // Properties
    // =========================================================================

    /**
     * @var
     */
    public $user;

    /**
     * @var
     */
    public $initialOrderToken;

    /**
     * @var
     */
    public $firstInvoiceReceivedOn;

    /**
     * @var
     */
    public $schedule;

    /**
     * @var
     */
    public $itemId;

    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $creationDate;

    /**
     * @var
     */
    public $modificationDate;

    /**
     * @var
     */
    public $cancelledOn;

    /**
     * @var
     */
    public $amount;

    /**
     * @var
     */
    public $quantity;

    /**
     * @var
     */
    public $userDefinedId;

    /**
     * @var
     */
    public $totalSpent;

    /**
     * @var
     */
    public $status;

    /**
     * @var
     */
    public $gatewayId;

    /**
     * @var
     */
    public $metadata;

    /**
     * @var
     */
    public $cartId;

    /**
     * @var
     */
    public $recurringShipping;
}
