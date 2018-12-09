<?php
/**
 * Snipcart plugin for Craft CMS 3.x
 *
 * @link      https://workingconcept.com
 * @copyright Copyright (c) 2018 Working Concept Inc.
 */

namespace workingconcept\snipcart\models;

use craft\base\Model;

/**
 * ShipStation Weight Model
 * https://www.shipstation.com/developer-api/#/reference/model-weight
 */

class ShipStationWeight extends Model
{
    // Constants
    // =========================================================================

    const UNIT_POUNDS = 'pounds';
    const UNIT_OUNCES = 'ounces';
    const UNIT_GRAMS  = 'grams';


    // Properties
    // =========================================================================

    /**
     * @var int Weight value.
     */
    public $value;

    /**
     * @var string Units of weight. See class constants.
     */
    public $units;

    /**
     * @var int|null (read only) A numeric value that is equivalent to the above units field.
     */
    public $WeightUnits;


    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'number', 'integerOnly' => true],
            [['units'], 'string'],
            [['units'], 'in', 'range' => [self::UNIT_POUNDS, self::UNIT_OUNCES, self::UNIT_GRAMS]],
        ];
    }

}
