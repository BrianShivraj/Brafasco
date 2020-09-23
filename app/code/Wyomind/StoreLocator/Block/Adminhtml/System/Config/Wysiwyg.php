<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Block\Adminhtml\System\Config;

use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
/**
 * Class Wysiwyg
 * @package Wyomind\StoreLocator\Block\Adminhtml
 */
class Wysiwyg extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var  Registry
     */
    protected $_coreRegistry;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, Context $context, array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($context, $data);
    }
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        // set wysiwyg for element
        $element->setWysiwyg(true);
        // set configuration values
        $element->setConfig($this->_wysiwygConfig->getConfig($element));
        return parent::_getElementHtml($element);
    }
}