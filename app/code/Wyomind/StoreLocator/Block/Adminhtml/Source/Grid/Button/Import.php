<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wyomind\StoreLocator\Block\Adminhtml\Source\Grid\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Wyomind\StoreLocator\Helper\Acl;
/**
 * Class DeleteButton
 */
class Import implements ButtonProviderInterface
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
        if ($this->authorization->isAllowed(Acl::SOURCE_IMPORT)) {
            $data = ['label' => __('Import a CSV file'), 'class' => 'Primary', "on_click" => 'require(["Wyomind_StoreLocator_Import"], function(Wyomind_StoreLocator_Import) {Wyomind_StoreLocator_Import.importCsvModal();});', 'sort_order' => 20];
            return $data;
        }
    }
}