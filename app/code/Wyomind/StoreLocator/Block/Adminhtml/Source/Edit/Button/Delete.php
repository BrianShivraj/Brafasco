<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Block\Adminhtml\Source\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Wyomind\StoreLocator\Helper\Acl;
/**
 * Class DeleteButton
 */
class Delete implements ButtonProviderInterface
{
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind)
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
    }
    /**
     * @inheritDoc
     */
    public function getButtonData()
    {
        if ($this->getSourceId() != "default" && $this->authorization->isAllowed(Acl::SOURCE_DELETE)) {
            $data = ['label' => __('Delete source'), 'class' => 'delete', 'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to do this?') . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})', 'sort_order' => 20];
            return $data;
        }
    }
    /**
     * URL to send delete requests to.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('storelocator/source/delete', ['source_id' => $this->getSourceId()]);
    }
    /**
     * @return mixed|null
     */
    public function getSourceId()
    {
        try {
            return $this->context->getRequest()->getParam('source_code');
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }
    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}