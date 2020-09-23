<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Block;

/**
 * Class StoreLocator
 * @package Wyomind\StoreLocator\Block
 */
class StoreLocator extends \Magento\Framework\View\Element\Template
{
    /**
     * @var null
     */
    protected $sources = null;
    /**
     * @var \Magento\Directory\Model\CurrencyFactory|null
     */
    protected $symbolFactory = null;
    /**
     * @var bool
     */
    protected $_isClickNCollect = false;
    /**
     * @var \Magento\Directory\Model\Region
     */
    protected $_regionModel = null;
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider|null
     */
    protected $_filterProvider = null;
    /**
     * @var \Wyomind\StoreLocator\Model\ResourceModel\Source\Collection
     */
    protected $sourceCollection;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Magento\Framework\View\Element\Template\Context $context, \Wyomind\StoreLocator\Model\ResourceModel\Source\CollectionFactory $sourceCollection, \Magento\Directory\Model\CurrencyFactory $symbolFactory, array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($context, $data);
        $this->symbolFactory = $symbolFactory;
        $this->_isClickNCollect = strpos($this->request->getUriString(), "clickncollect") !== FALSE;
        $this->sourceCollection = $sourceCollection;
    }
    /**
     * @return int|\Wyomind\Framework\Helper\type
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getNbStoresToDisplay()
    {
        return $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::DISPLAY_X_FIRST, $this->_storeManager->getStore()->getStoreId());
    }
    /**
     * @return \Wyomind\Framework\Helper\type
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDisplayDistance()
    {
        return $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::DISPLAY_DISTANCE, $this->_storeManager->getStore()->getStoreId());
    }
    /**
     * @return \Wyomind\Framework\Helper\type
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDisplayDuration()
    {
        return $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::DISPLAY_DURATION, $this->_storeManager->getStore()->getStoreId());
    }
    /**
     * @return \Wyomind\Framework\Helper\type
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getUnitSystem()
    {
        return $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::UNIT_SYSTEM, $this->_storeManager->getStore()->getStoreId());
    }
    /**
     * @param $sources
     */
    public function setSources($sources)
    {
        $this->sources = $sources;
    }
    /**
     * @return bool
     */
    public function isClickNCollect()
    {
        return $this->_isClickNCollect;
    }
    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrencySymbol()
    {
        return $this->symbolFactory->create()->load($this->_storeManager->getStore()->getCurrentCurrency()->getCode())->getCurrencySymbol();
    }
    /**
     * @return null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSources()
    {
        $groupId = 0;
        $login = $this->session->isLoggedIn();
        if (!$this->framework->isAdmin()) {
            if ($login) {
                $groupId = $this->session->getCustomerGroupId();
            }
        }
        if ($this->sources !== null) {
            $collection = $this->sources;
        } else {
            $collection = $this->sourceCollection->create()->getSourceByStoreId($this->_storeManager->getStore()->getStoreId(), true, $groupId);
            $collection->setOrder("display_order", "ASC");
        }
        return $collection;
    }
    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCountries()
    {
        $groupId = 0;
        $login = $this->session->isLoggedIn();
        if (!$this->framework->isAdmin()) {
            if ($login) {
                $groupId = $this->session->getCustomerGroupId();
            }
        }
        $collection = $this->sourceCollection->create()->getCountries($this->_storeManager->getStore()->getStoreId(), true, $groupId);
        $countries = [];
        foreach ($collection as $country) {
            if ($country->getCountryId()) {
                $countryModel = $this->_countryModel->loadByCode($country->getCountryId());
                $countryName = $countryModel->getName();
                $countries[] = ['code' => $country->getCountryId(), 'name' => $countryName];
            }
        }
        return $countries;
    }
    /**
     * @return false|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getJsonData()
    {
        $i = 0;
        $data = [];
        foreach ($this->getSources() as $source) {
            $fullAddress = $source->getStreet();
            if ($source->getAdditionalStreet()) {
                $fullAddress .= "," . $source->getAdditionalStreet();
            }
            $fullAddress .= "," . $source->getCity();
            if ($source->getCountryId()) {
                $fullAddress .= "," . $this->_countryModel->loadByCode($source->getCountryId())->getName();
            }
            if (!$source->getGoogleRequest()) {
                $request = $fullAddress;
            } else {
                $request = $source->getGoogleRequest();
            }
            $data[] = ["id" => $source->getSourceCode(), "title" => "<h4><b>" . $source->getName() . "</b></h4>", "links" => ["directions" => "<a href=\"javascript:void(0);\" onclick=\"require(['storelocator'], function(storelocator) {storelocator.getDirections(" . $i . ")});\">" . __("Get Directions") . "</a>", "showOnMap" => "<a href=\"//maps.google.com/maps?q=" . $request . "\">" . __("Show on Google Map") . "</a>"], "name" => $source->getName(), "lat" => $source->getLatitude(), "lng" => $source->getlongitude(), "country" => $source->getCountryId(), "duration" => ["text" => null, "value" => null], "distance" => ["text" => null, "value" => null]];
            $i++;
        }
        return json_encode($data);
    }
    /**
     * @return null|\Wyomind\StoreLocator\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }
    /**
     * @return \Wyomind\Framework\Helper\type
     */
    public function getGoogleApiKey()
    {
        return $this->gmapHelper->getGoogleApiKey();
    }
}
