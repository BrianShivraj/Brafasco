<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Ui\DataProvider;

class AttributesProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    /**
     * @var array
     */
    protected $_loadedData;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, $name, $primaryFieldName, $requestFieldName, array $meta = [], array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        $this->collection = $this->repository->list();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}