<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Store;

class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    /**
     * @var \Wyomind\StoreLocator\Api\SourceRepositoryInterface
     */
    protected $sourceRepository;


    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Wyomind\StoreLocator\Api\SourceRepositoryInterface $sourceRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\InventoryApi\Api\SourceRepositoryInterface $sourceRepository
    )
    {

        $this->_resultPageFactory=$resultPageFactory;
        $this->sourceRepository=$sourceRepository;
        parent::__construct($context);

    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $sourceCode=$this->getRequest()->getParam('source_code');
        
        $source=$this->sourceRepository->get($sourceCode);

        $resultPage=$this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($source->getName());
        return $resultPage;
    }
}
