<?php

/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Block;

/**
 * Class Store
 * @package Wyomind\StoreLocator\Block
 */
class Store extends \Wyomind\StoreLocator\Block\StoreLocator
{
    /**
     * @var null
     */
    protected $source = null;
    /**
     * @var int|mixed
     */
    protected $sourceCode = 0;
    /**
     * @var \Magento\Directory\Model\Region
     */
    protected $regionModel = null;
    /**
     * @var \Magento\Framework\Locale\ListsInterface|null
     */
    protected $localLists = null;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Magento\Framework\View\Element\Template\Context $context, \Wyomind\StoreLocator\Model\ResourceModel\Source\CollectionFactory $sourceCollection, \Magento\Directory\Model\CurrencyFactory $symbolFactory, array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($wyomind, $context, $sourceCollection, $symbolFactory, $data);
        $this->sourceCode = $this->getRequest()->getParam('source_code');
        $this->source = $this->sourceRepository->get($this->sourceCode);
    }
    /**
     * @return null|string
     */
    public function getStoreName()
    {
        return $this->source->getName();
    }
    /**
     * @return float|null
     */
    public function getStoreLatitude()
    {
        return $this->source->getLatitude();
    }
    /**
     * @return float|null
     */
    public function getStoreLongitude()
    {
        return $this->source->getLongitude();
    }
    /**
     * @return string
     */
    public function getStoreGoogleRequest()
    {
        $fullAddress = $this->source->getStreet();
        if ($this->source->getExtensionAttributes()->getSource()->getStreetAdditionnal()) {
            $fullAddress .= "," . $this->source->getExtensionAttributes()->getSource()->getStreetAdditionnal();
        }
        $fullAddress .= "," . $this->source->getCity();
        if ($this->source->getCountryCode()) {
            $fullAddress .= "," . $this->countryModel->loadByCode($this->source->getCountryCode())->getName();
        }
        return $fullAddress;
    }
    /**
     * @return \Magento\InventoryApi\Api\Data\SourceInterface|null|\Wyomind\StoreLocator\Api\Data\SourceInterface
     */
    public function getSource()
    {
        return $this->source;
    }
    public function getUseConfigPage()
    {
        return $this->source->getExtensionAttributes()->getSource()->getUseConfigPage();
    }
}