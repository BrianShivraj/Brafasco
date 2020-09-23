<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Adminhtml\Attributes;

use \Wyomind\StoreLocator\Helper\Acl;

class Delete extends \Wyomind\StoreLocator\Controller\Adminhtml\Attributes
{
    public function execute()
    {
        $id=$this->getRequest()->getParam('attribute_id');

        if ($id) {
            try {
                $model=$this->_objectManager->create('Wyomind\StoreLocator\Model\Attributes');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The attribute has been deleted.'));
                $this->_redirect('storelocator/attributes/index');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('storelocator/attributes/edit', ['attribute_id'=>$id]);
                return;
            }
        }

        $this->messageManager->addError(__("We can't find an attribute to delete."));
        $this->_redirect('storelocator/attributes/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(Acl::ATTRIBUTE_DELETE);
    }
}