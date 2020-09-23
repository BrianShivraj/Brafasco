<?php


/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Index;

/**
 * Magento Version controller
 */
class Index extends \Magento\Framework\App\Action\Action
{

    protected $_resultPageFactory;
    /**
     * @var \Wyomind\Framework\Helper\Module
     */
    protected $framework;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Wyomind\Framework\Helper\Module $framework
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Wyomind\Framework\Helper\Module $framework
    ) {
        $this->_resultPageFactory=$resultPageFactory;
        parent::__construct($context);
        $this->framework=$framework;
    }

    /**
     * Load the page defined in view/frontend/layout/samplenewpage_index_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $resultPage=$this->_resultPageFactory->create();
        $title=$this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::STORELOCATOR_TITLE);
        $resultPage->getConfig()->getTitle()->set($title);

        return $resultPage;
    }
}
