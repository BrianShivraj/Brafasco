<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Model\Attributes;

use Wyomind\StoreLocator\Api\Data\AttributesInterface;
use Wyomind\StoreLocator\Api\AttributesRepositoryInterface;
use Wyomind\StoreLocator\Model\ResourceModel\Attributes\Collection;
class Repository implements AttributesRepositoryInterface
{
    /**
     * @var \Wyomind\StoreLocator\Model\ResourceModel\Attributes\CollectionFactory
     */
    protected $collectionFactory;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Wyomind\StoreLocator\Model\ResourceModel\Attributes\CollectionFactory $collectionFactory)
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        $this->collectionFactory = $collectionFactory;
    }
    /**
     * @param $code
     * @return AttributesInterface
     */
    function get($code) : AttributesInterface
    {
        $object = $this->attributes->load($code, AttributesInterface::CODE);
        return $object;
    }
    function list() : Collection
    {
        return $this->collectionFactory->create();
    }
}