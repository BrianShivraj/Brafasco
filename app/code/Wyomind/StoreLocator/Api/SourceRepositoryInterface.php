<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Api;

use \Wyomind\StoreLocator\Api\Data\SourceInterface;

/**
 * Interface SourceRepositoryInterface
 * @package Wyomind\StoreLocator\Api
 */
interface SourceRepositoryInterface
{
    /**
     * @param $code
     * @return SourceInterface
     */
    function get($code): SourceInterface;

    /**
     * @param $urlKey
     * @return SourceInterface
     */
    function getByUrlKey($urlKey): SourceInterface;

    /**
     * @param $code
     * @return mixed
     */
    function delete($code): void;

}