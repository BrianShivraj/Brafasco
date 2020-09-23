<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Model\Config\Source;

class UnitSystem implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            ['label' => 'Metric', 'value' => 0],
            ['label' => 'Imperial', 'value' => 1]
        ];
    }
}

