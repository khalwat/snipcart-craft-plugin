<?php
/**
 * Snipcart plugin for Craft CMS 3.x
 *
 * @link      https://workingconcept.com
 * @copyright Copyright (c) 2018 Working Concept Inc.
 */

namespace workingconcept\snipcart\models;

use Craft;
use craft\base\Model;

/**
 * https://docs.snipcart.com/api-reference/custom-shipping-methods
 */

class SnipcartShippingRate extends Model
{

    // Properties
    // =========================================================================

    /**
     * @var float
     */
    public $cost;
    
    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $code;

    /**
     * @var int
     */
    public $guaranteedDaysToDelivery;


    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guaranteedDaysToDelivery'], 'number', 'integerOnly' => true],
            [['cost'], 'number', 'integerOnly' => false],
            [['description', 'code'], 'string'],
            [['cost', 'description'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $return = [
            'cost',
            'description',
        ];

        if ( ! empty($this->code))
        {
            $return[] = 'code';
        }

        if( ! empty($this->guaranteedDaysToDelivery))
        {
            $return[] = 'guaranteedDaysToDelivery';
        }

        return $return;
    }
}
