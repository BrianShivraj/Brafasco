<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Adminhtml\Attributes;

use \Wyomind\StoreLocator\Helper\Acl;

class Edit extends \Wyomind\StoreLocator\Controller\Adminhtml\Attributes
{
    public function execute()
    {
        $id=$this->getRequest()->getParam('attribute_id');
        $attribute=$this->_attributesModelFactory->create();

        if ($id) {
            $attribute->load($id);
            if (!$attribute->getAttributeId()) {
                $this->messageManager->addError(__('This attribute no longer exists.'));
                $this->_redirect("storelocator/attributes/index");
                return;
            }
        }

        $this->_coreRegistry->register('attribute', $attribute);

        $title=$attribute->getId() ? __('Edit Attribute: ') . $attribute->getCode() : __('New Attribute');
        $this->_initAction($title);
        $this->_view->renderLayout();
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(Acl::ATTRIBUTE_VIEW);
    }

}