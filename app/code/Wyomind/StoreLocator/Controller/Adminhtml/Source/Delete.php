<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Adminhtml\Source;

use \Wyomind\StoreLocator\Helper\Acl;

/**
 * Class Delete
 * @package Wyomind\StoreLocator\Controller\Adminhtml\Source
 */
class Delete extends \Wyomind\StoreLocator\Controller\Adminhtml\Source
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $sourceCode=$this->getRequest()->getParam('source_id');

        if ($sourceCode) {
            try {

                $this->storelocatorRepository->delete($sourceCode);
                $this->messageManager->addSuccess(__('The source has been deleted.'));
                $this->_redirect('inventory/source/index');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('inventory/source/edit', ['source_code'=>$sourceCode]);
                return;
            }
        }

        $this->messageManager->addError(__("We can't find the source to delete."));
        $this->_redirect('inventory/source/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(Acl::SOURCE_DELETE);
    }
}