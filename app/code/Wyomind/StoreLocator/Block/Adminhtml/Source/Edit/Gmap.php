<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Block\Adminhtml\Source\Edit;

class Gmap extends \Magento\Backend\Block\Template
{
    /**
     * Block template.
     * @var string
     */
    protected $_template = 'source/edit/gmap.phtml';
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($context, $data);
    }
    /**
     * @return mixed
     */
    public function getGoogleApiKey()
    {
        return $this->gmapHelper->getGoogleApiKey();
    }
}