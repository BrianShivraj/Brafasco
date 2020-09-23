<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Model\ResourceModel\Attributes;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wyomind\StoreLocator\Model\Attributes', 'Wyomind\StoreLocator\Model\ResourceModel\Attributes');
    }


    public function getByCode($code) {
        $this->addFieldToFilter("code", ["eq" => $code]);
        return $this;
    }

}
