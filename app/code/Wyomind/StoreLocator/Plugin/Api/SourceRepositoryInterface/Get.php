<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Plugin\Api\SourceRepositoryInterface;

use Magento\InventoryApi\Api\Data\SourceInterface as NativeSourceInterface;
use Magento\InventoryApi\Api\Data\SourceExtension;
use Wyomind\StoreLocator\Api\Data\SourceInterface as SourceInterface;
/**
 * Class Get
 * @package Wyomind\StoreLocator\Plugin\Api\SourceRepositoryInterface
 */
class Get
{
    /**
     * @var \Wyomind\StoreLocator\Model\ResourceModel\AttributesValues\CollectionFactory
     */
    protected $valuesCollectionFactory;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Wyomind\StoreLocator\Model\ResourceModel\AttributesValues\CollectionFactory $valuesCollectionFactory)
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        $this->valuesCollectionFactory = $valuesCollectionFactory;
    }
    /**
     * @param \Magento\InventoryApi\Api\SourceRepositoryInterface $subject
     * @param \Magento\InventoryApi\Api\Data\SourceInterface $resultSource
     * @return \Magento\InventoryApi\Api\Data\SourceInterface|mixed
     */
    public function afterGet(\Magento\InventoryApi\Api\SourceRepositoryInterface $subject, \Magento\InventoryApi\Api\Data\SourceInterface $resultSource)
    {
        try {
            $extensionAttributes = $this->objectManager->create(SourceExtension::class);
            $sourceModel = $this->sourceRepository->get($resultSource->getData(NativeSourceInterface::SOURCE_CODE));
            $collection = $this->attributeRepository->list();
            foreach ($collection as $field) {
                $valueAttribute = $this->valuesCollectionFactory->create();
                $value = $valueAttribute->getBySourceId($resultSource->getData(NativeSourceInterface::SOURCE_CODE), $field->getAtributeId())->getFirstItem();
                $sourceModel->setData($field->getCode(), $value->getvalue());
            }
            $regionCode = $this->source->getRegionCode($resultSource->getData("region_id"));
            $resultSource->setRegionCode($regionCode);
            $extensionAttributes->setSource($sourceModel);
            $resultSource->setExtensionAttributes($extensionAttributes);
        } catch (NoSuchEntityException $e) {
            return $resultSource;
        }
        return $resultSource;
    }
}