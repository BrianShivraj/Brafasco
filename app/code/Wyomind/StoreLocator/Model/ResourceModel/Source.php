<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Model\ResourceModel;


use Magento\InventoryApi\Api\Data\SourceInterface;
use Magento\Inventory\Model\ResourceModel\Source as SourceResourceModel;
use Wyomind\StoreLocator\Api\Data\SourceInterface as StoreLocatorSourceInterface;

/**
 * Store Locator mysql resource
 */
class Source extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     *
     */
    const TABLE_NAME_SOURCE_STORELOCATOR='inventory_source_storelocator';


    /**
     *
     */
    protected function _construct()
    {

        $this->_init(self::TABLE_NAME_SOURCE_STORELOCATOR, StoreLocatorSourceInterface::SOURCE_CODE);
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\Magento\Framework\Model\AbstractModel $object)
    {

        $this->getConnection()->insertOnDuplicate($this->getTable(self::TABLE_NAME_SOURCE_STORELOCATOR), $object->getData());

        return parent::save($object);
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $code
     * @return $this|\Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
    public function deleteSource($code)
    {

        $this->getConnection()->delete($this->getTable(SourceResourceModel::TABLE_NAME_SOURCE), ["source_code='" . $code . "'"]);
        return $this;
    }


    public function getRegionCode($regionId)
    {


        $tableRegion=$this->getTable("directory_country_region");
        $select=$this->getConnection()->select()
            ->from($tableRegion)
            ->reset(\Zend_Db_Select::COLUMNS)
            ->columns(["code as region_code"])
            ->where("region_id='" . $regionId."'");

        return $this->getConnection()->fetchOne($select);


    }


}
