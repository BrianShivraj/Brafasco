<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Adminhtml\Attributes;

use \Wyomind\StoreLocator\Helper\Acl;

class Index extends \Wyomind\StoreLocator\Controller\Adminhtml\Attributes
{
    public function execute()
    {

        $this->_initAction(__('Attributes'));
        $this->_view->renderLayout();
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(Acl::ATTRIBUTE_LIST);
    }
}