<?php

namespace Woom\CmsPagesInMenu\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
use Woom\CmsPagesInMenu\Model\PageInMenuInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->addMenuColumnsToCmsTable($setup);

        $setup->endSetup();
    }

    /**
     * Create menu columns to CMS table
     *
     * @param SchemaSetupInterface $setup
     *
     * @return $this
     */
    protected function addMenuColumnsToCmsTable(SchemaSetupInterface $setup)
    {
        /**
         * Add columns to table 'store'
         */
        $setup->getConnection()->addColumn(
            $setup->getTable(PageInMenuInterface::PAGE_TABLE),
            PageInMenuInterface::IS_IN_MENU,
            [
                'type'     => Table::TYPE_SMALLINT,
                'length'   => 1,
                'nullable' => false,
                'default'  => 0,
                'comment'  => 'Included In Menu Flag'
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable(PageInMenuInterface::PAGE_TABLE),
            PageInMenuInterface::MENU_LABEL,
            [
                'type'     => Table::TYPE_TEXT,
                'length'   => 255,
                'comment'  => 'Menu Label'
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable(PageInMenuInterface::PAGE_TABLE),
            PageInMenuInterface::MENU_ADD_TYPE,
            [
                'type'     => Table::TYPE_SMALLINT,
                'length'   => 1,
                'nullable' => false,
                'default'  => 0,
                'comment'  => 'Menu Add Type'
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable(PageInMenuInterface::PAGE_TABLE),
            PageInMenuInterface::MENU_ADD_CATEGORY_ID,
            [
                'type'     => Table::TYPE_INTEGER,
                'length'   => null,
                'comment'  => 'Menu Add Category Id'
            ]
        );

        return $this;
    }
}
