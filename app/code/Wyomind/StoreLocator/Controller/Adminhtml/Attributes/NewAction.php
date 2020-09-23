<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Adminhtml\Attributes;

use \Wyomind\StoreLocator\Helper\Acl;

class NewAction extends \Wyomind\StoreLocator\Controller\Adminhtml\Attributes
{
    public function execute()
    {
        $this->_forward('edit');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(Acl::ATTRIBUTE_CREATE);
    }
}