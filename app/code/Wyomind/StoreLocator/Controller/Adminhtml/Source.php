<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Adminhtml;

use Magento\Backend\App\Action;

/**
 * Class Source
 * @package Wyomind\StoreLocator\Controller\Adminhtml
 */
abstract class Source extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;
    /**
     * @var
     */
    protected $_attributesModelFactory;
    /**
     * @var
     */
    protected $_attributesCollectionFactory;
    /**
     * @var \Magento\Inventory\Model\ResourceModel\Source\Collection
     */
    protected $collection;
    /**
     * @var \Wyomind\Framework\Helper\Module
     */
    protected $framework;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;
    /**
     * @var \Magento\InventoryApi\Api\SourceRepositoryInterface
     */
    protected $sourceRepository;
    /**
     * @var \Magento\InventoryApi\Api\Data\SourceInterface
     */
    protected $source;
    /**
     * @var \Wyomind\StoreLocator\Plugin\Api\SourceRepositoryInterface
     */
    protected $storelocatorRepository;

    /**
     * Source constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory $collection
     * @param \Wyomind\Framework\Helper\Module $framework
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\InventoryApi\Api\SourceRepositoryInterface $sourceRepository
     * @param \Magento\InventoryApi\Api\Data\SourceInterface $source
     * @param \Wyomind\StoreLocator\Api\SourceRepositoryInterface $storelocatorRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory $collection,
        \Wyomind\Framework\Helper\Module $framework,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\InventoryApi\Api\SourceRepositoryInterface $sourceRepository,
        \Magento\InventoryApi\Api\Data\SourceInterface $source,
        \Wyomind\StoreLocator\Api\SourceRepositoryInterface $storelocatorRepository
    ) {


        parent::__construct($context);
        $this->dataPersistor=$dataPersistor;
        $this->resultJsonFactory=$resultJsonFactory;
        $this->coreRegistry=$coreRegistry;
        $this->filter=$filter;
        $this->framework=$framework;
        $this->collection=$collection;
        $this->filesystem=$filesystem;
        $this->sourceRepository=$sourceRepository;
        $this->source=$source;
        $this->storelocatorRepository=$storelocatorRepository;
    }


}