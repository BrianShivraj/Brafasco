<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */


namespace Wyomind\StoreLocator\Api;

use \Wyomind\StoreLocator\Api\Data\AttributesInterface;
use \Wyomind\StoreLocator\Model\ResourceModel\Attributes\Collection;

interface AttributesRepositoryInterface
{
    /**
     * @param $id
     * @return AttributesInterface
     */
    function get($id): AttributesInterface;

    /**
     * @return \Wyomind\StoreLocator\Model\ResourceModel\Attributes\Collection
     */
    function list(): Collection;

}