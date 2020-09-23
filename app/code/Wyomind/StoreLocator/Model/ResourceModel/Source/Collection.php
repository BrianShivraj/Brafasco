<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Model\ResourceModel\Source;

use Magento\Inventory\Model\ResourceModel\Source;
use Wyomind\StoreLocator\Model\ResourceModel\Source as AdditionalSource;
use Wyomind\StoreLocator\Api\Data\SourceInterface;
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
        $this->_init('Wyomind\\StoreLocator\\Model\\Source', 'Wyomind\\StoreLocator\\Model\\ResourceModel\\Source');
    }
    /**
     * Collection constructor.
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     * @throws \Zend_Db_Select_Exception
     */
    public function __construct(\Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Framework\DB\Adapter\AdapterInterface $connection = null, \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null)
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $joinTable = $this->getTable(Source::TABLE_NAME_SOURCE);
        if (!array_key_exists($joinTable, $this->getSelect()->getPart('from'))) {
            $this->getSelect()->join($joinTable, "main_table." . SourceInterface::SOURCE_CODE . '=' . $joinTable . ".source_code");
        }
        return $this;
    }
    /**
     * @param $sourceCode
     * @return $this
     */
    public function getSource($sourceCode)
    {
        $this->getSelect()->where(SourceInterface::SOURCE_CODE . "='" . $sourceCode . "'")->limit(1);
        return $this;
    }
    /**
     * @param $storeId
     * @param bool $enabled
     * @param $groupId
     * @return $this
     * @throws \Zend_Db_Select_Exception
     */
    public function getSourceByStoreId($storeId, $enabled = false, $groupId = null)
    {
        $joinTable = $this->getTable(Source::TABLE_NAME_SOURCE);
        $joinTableRegion = $this->getTable("directory_country_region");
        $where = null;
        if ($groupId !== null) {
            $where .= " AND FIND_IN_SET(" . $groupId . ", main_table.customer_group_ids) ";
        }
        if ($enabled !== false) {
            $this->addFieldToFilter('enabled', array('eq' => 1));
            $this->addFieldToFilter('visible_in_storelocator', array('eq' => 1));
        }
        $this->getSelect()->joinLeft($joinTableRegion, $joinTable . ".region_id=" . $joinTableRegion . ".region_id", ["region_code" => $joinTableRegion . ".code"])->where("(FIND_IN_SET(" . $storeId . "," . "main_table.store_ids) ) " . $where)->order('display_order ASC');
        return $this;
    }
    /**
     * @param $storeId
     * @param bool $enabled
     * @param null $groupId
     * @return $this
     */
    public function getCountries($storeId, $enabled = false, $groupId = null)
    {
        $joinTable = $this->getTable(Source::TABLE_NAME_SOURCE);
        $where = null;
        if ($enabled !== false) {
            $this->addFieldToFilter('enabled', array('eq' => 1));
            $this->addFieldToFilter('visible_in_storelocator', array('eq' => 1));
        }
        if ($groupId !== null) {
            $where .= " AND FIND_IN_SET(" . $groupId . ", main_table.customer_group_ids) ";
        }
        $this->getSelect()->where("FIND_IN_SET(" . $storeId . ", main_table.store_ids) OR store_ids=0 " . $where)->reset(\Zend_Db_Select::COLUMNS)->columns([$joinTable . ".country_id"])->group($joinTable . '.country_id');
        return $this;
    }
    /**
     * @return $this
     */
    public function getLastInsertedId()
    {
        $this->getSelect()->order(SourceInterface::SOURCE_CODE . ' DESC')->limit(1);
        return $this;
    }
    /**
     * @param $urlKey
     * @return \Magento\Framework\DataObject|null
     */
    public function getByUrlKey($urlKey)
    {
        $collection = $this->addFieldToFilter("url_key", ['eq' => $urlKey])->addFieldToFilter("enabled", ['eq' => 1]);
        if (count($collection)) {
            return $this->getFirstItem();
        } else {
            return null;
        }
    }
}