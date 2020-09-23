<?php
/**
 * Copyright © 2018 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Helper;

/**
 * Core general helper
 */
class Gmap extends \Wyomind\Framework\Helper\Module
{


    public function getGoogleApiKey()
    {
        return $this->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::GOOGLE_API);
    }
}