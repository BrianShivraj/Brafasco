<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Block\Adminhtml\Attributes\Edit;

use \Wyomind\StoreLocator\Helper\Acl;

/**
 * Class DeleteButton
 * @package Wyomind\StoreLocator\Block\Adminhtml\Attributes\Edit
 */
class DeleteButton extends GenericButton implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data=[];
        $id=$this->getId();
        if ($id && $this->canRender(Acl::ATTRIBUTE_DELETE)) {
            $data=[
                'label'=>__('Delete attribute'),
                'on_click'=>'deleteConfirm(\'' . __(
                        'Are you sure you want to delete the attribute?'
                    ) . '\', \'' . $this->urlBuilder->getUrl('*/attributes/delete', ['attribute_id'=>$id]) . '\')',
                'class'=>'delete',
                'sort_order'=>20
            ];
        }

        return $data;
    }


}