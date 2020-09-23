<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Model\ResourceModel\AttributesValues;

use \Wyomind\StoreLocator\Model\ResourceModel\Attributes;
use \Wyomind\StoreLocator\Api\Data\AttributesValuesInterface;
/**
 * Class Collection
 * @package Wyomind\StoreLocator\Model\ResourceModel\AttributesValues
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wyomind\StoreLocator\Model\AttributesValues', 'Wyomind\StoreLocator\Model\ResourceModel\AttributesValues');
    }

    /**
     * @param $sourceCode
     * @return $this
     */
    public function getBySourceId($sourceCode, $attributeId=false)
    {

        $this->addFieldToFilter(AttributesValuesInterface::SOURCE_CODE, ["eq"=>$sourceCode]);
        if ($attributeId) {
            $this->addFieldToFilter("main_table.attribute_id", ["eq"=>$attributeId]);
        }
        $attributes=$this->getTable(Attributes::TABLE_NAME_STORE_LOCATOR_ATTRIBUTES);
        $this->join($attributes, $attributes . ".attribute_id = main_table.attribute_id", ["code"]);

        return $this;
    }

}
