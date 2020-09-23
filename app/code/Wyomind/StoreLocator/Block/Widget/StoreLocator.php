<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Block\Widget;

use Magento\Framework\View\Element\Template;
/**
 * Class StoreLocator
 * @package Wyomind\StoreLocator\Block\Widget
 */
class StoreLocator extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = "link.phtml";
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Magento\Framework\View\Element\Template\Context $context, array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($context, $data);
    }
    /**
     * @return \Wyomind\Framework\Helper\type
     */
    public function getPageUrl()
    {
        return $this->getUrl() . $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::STORELOCATOR_URL);
    }
}