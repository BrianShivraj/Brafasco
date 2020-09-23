<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Block\Adminhtml\Source\Edit;

class NoAdditionalFields extends \Magento\Backend\Block\Template
{
    /**
     * Block template.
     */
    protected $_template = 'source/edit/noadditionalfields.phtml';
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($context, $data);
    }
    public function countAdditionalFields()
    {
        return count($this->repository->list());
    }
}