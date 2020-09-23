<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Block\Adminhtml\Attributes\Edit;

use \Wyomind\StoreLocator\Helper\Acl;

class SaveAndContinueButton extends GenericButton implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{


    /**
     * @return array
     */
    public function getButtonData()
    {
        $data=[];
        if ($this->canRender(Acl::ATTRIBUTE_EDIT)) {
            $data=[
                'label'=>__('Save and Continue Edit'),
                'on_click'=>'',
                'class'=>'save',
                'sort_order'=>40
            ];
        }

        return $data;
    }
}