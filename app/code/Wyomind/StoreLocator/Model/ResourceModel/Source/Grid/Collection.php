<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */


namespace Wyomind\StoreLocator\Model\ResourceModel\Source\Grid;

use Wyomind\StoreLocator\Api\Data\SourceInterface;

/**
 * Resource Collection of Source entities
 *
 * @api
 */
class Collection extends \Magento\Inventory\Model\ResourceModel\Source\Collection
{
    /**
     * @return \Magento\Inventory\Model\ResourceModel\Source\Collection|void
     */
    protected function _beforeLoad()
    {

        parent::_beforeLoad();

        $storeLocator=$this->getTable(\Wyomind\StoreLocator\Model\ResourceModel\Source::TABLE_NAME_SOURCE_STORELOCATOR);

        $this->getSelect()->joinLeft(
            $storeLocator,
            $storeLocator . "." . SourceInterface::SOURCE_CODE . "= main_table.source_code"

        );
        $this->getSelect()->columns(["main_table.source_code as source_code"]);


    }


}