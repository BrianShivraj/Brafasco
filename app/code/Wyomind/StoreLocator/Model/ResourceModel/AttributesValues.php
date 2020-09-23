<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Model\ResourceModel;

/**
 * Class AttributesValues
 * @package Wyomind\StoreLocator\Model\ResourceModel
 */
class AttributesValues extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     *
     */
    const TABLE_NAME_ATTRIBUTES_VALUES='storelocator_attributes_values';

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME_ATTRIBUTES_VALUES, 'value_id');
    }

    public function save(\Magento\Framework\Model\AbstractModel $object)
    {

        $this->getConnection()->insertOnDuplicate($this->getTable(self::TABLE_NAME_ATTRIBUTES_VALUES), $object->getData());

    }
}
