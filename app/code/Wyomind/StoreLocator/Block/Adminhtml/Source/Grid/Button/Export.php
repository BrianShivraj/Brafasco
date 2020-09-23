<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Block\Adminhtml\Source\Grid\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Wyomind\StoreLocator\Helper\Acl;
/**
 * Class DeleteButton
 */
class Export implements ButtonProviderInterface
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
        if ($this->authorization->isAllowed(Acl::SOURCE_EXPORT)) {
            $data = ['label' => __('Export a CSV file'), 'class' => 'Primary', 'sort_order' => 10, "on_click" => "document.location='" . $this->getExportUrl() . "'"];
            return $data;
        }
    }
    /**
     * URL to send delete requests to.
     *
     * @return string
     */
    public function getExportUrl()
    {
        return $this->getUrl('storelocator/source/exportCsv');
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