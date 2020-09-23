<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $sourceCollection;
    protected $storeLocator;

    /**
     * InstallData constructor.
     * @param \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory $sourceCollection
     * @param \Wyomind\StoreLocator\Model\Source $storeLocator
     */
    public function __construct(
        \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory $sourceCollection,
        \Wyomind\StoreLocator\Model\Source $storeLocator

    ) {
        $this->sourceCollection=$sourceCollection;
        $this->storeLocator=$storeLocator;
    }


    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {

        unset($context);

        $installer=$setup;
        $installer->startSetup();
        $collection=$this->sourceCollection->create();

        foreach ($collection as $source) {

            $this->storeLocator->setSourceCode($source->getSourceCode());
            $this->storeLocator->save();

        }

        $installer->endSetup();

    }

}
