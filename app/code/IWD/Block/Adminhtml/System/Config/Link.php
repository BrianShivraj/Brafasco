<?php

namespace IWD\StoreLocator\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

class Link extends Field
{
    public $userGuideUrl = "https://www.iwdagency.com/customer/account/";

    protected function _getElementHtml(AbstractElement $element)
    {
        $element->getValue();
        return sprintf(
            '<span>
                        <a href="%s" target="_blank">%s</a>
                    </span>',
            $this->userGuideUrl,
            __('Login')
        );
    }
}
