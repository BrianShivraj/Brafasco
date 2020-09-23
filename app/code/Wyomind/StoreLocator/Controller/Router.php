<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{


    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;


    /**
     * @var \Wyomind\StoreLocator\Api\SourceRepositoryInterface
     */
    protected $sourceRepository;
    /**
     * @var \Wyomind\Framework\Helper\Module
     */
    protected $framework;

    /**
     * Router constructor.
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\ResponseInterface $response
     * @param \Wyomind\StoreLocator\Api\SourceRepositoryInterface $sourceRepository
     * @param \Wyomind\Framework\Helper\Module $framework
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Wyomind\StoreLocator\Api\SourceRepositoryInterface $sourceRepository,
        \Wyomind\Framework\Helper\Module $framework
    )
    {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->sourceRepository = $sourceRepository;
        $this->framework = $framework;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        if ($identifier == $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::STORELOCATOR_URL)) {
            $request->setModuleName('storelocator')
                ->setControllerName('index')
                ->setActionName('index');

            return $this->actionFactory->create(
                'Magento\Framework\App\Action\Forward',
                ['request' => $request]
            );
        }

        $source = $this->sourceRepository->getByUrlKey($identifier);

        if (!empty($source->getData())/* && $source->getSourceCodeOrig() == $identifier*/) {

            // if store found
            $request->setModuleName('storelocator')
                ->setControllerName('store')
                ->setActionName('index')
                ->setParam('source_code', $source->getSourceCode());

            return $this->actionFactory->create(
                'Magento\Framework\App\Action\Forward',
                ['request' => $request]
            );
        } else {
            return false;
        }
    }

}