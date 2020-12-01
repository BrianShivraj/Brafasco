<?php

namespace Woom\CmsPagesInMenu\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Cms\Helper\Page as PageHelper;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Data\Tree\Node;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\ResourceModel\Page\Collection as PageCollection;
use Woom\CmsPagesInMenu\Model\PageInMenuInterface;
use Woom\CmsPagesInMenu\Model\Source\MenuAddType;
use Magento\Framework\Exception\NoSuchEntityException;

class AddCmsToTopmenu implements ObserverInterface
{
    /**
     * Core registry
     *
     * @var Registry
     */
    private $registry;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * CMS page collection factory
     *
     * @var CollectionFactory
     */
    private $pageCollectionFactory;

    /**
     * CMS page helper
     *
     * @var PageHelper
     */
    private $pageHelper;

    /**
     * Node factory
     *
     * @var NodeFactory
     */
    private $nodeFactory;

    /**
     * AddCmsToTopmenu constructor.
     *
     * @param Registry              $registry
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory     $pageCollectionFactory
     * @param PageHelper            $pageHelper
     * @param NodeFactory           $nodeFactory
     */
    public function __construct(
        Registry $registry,
        StoreManagerInterface $storeManager,
        CollectionFactory $pageCollectionFactory,
        PageHelper $pageHelper,
        NodeFactory $nodeFactory
    ) {
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->pageHelper = $pageHelper;
        $this->nodeFactory = $nodeFactory;
    }

    /**
     * Add CMS to topmenu
     *
     * @param Observer $observer
     *
     * @return void
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        /** @var Node $menu */
        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $nodeMap = $menu->getAllChildNodes();

        $pageCollection = $this->getPageCollection();

        /** @var PageInterface $page */
        foreach ($pageCollection as $page) {
            $categoryNodeId = 'category-node-' . $page->getMenuAddCategoryId();
            if (array_key_exists($categoryNodeId, $nodeMap)) {
                /** @var Node $sibling */
                $sibling = $nodeMap[$categoryNodeId];

                /** @var Node $parent */
                $parent = $sibling->getParent();

                //append cms menu
                $parentChildren = $parent->getChildren()->getNodes();
                foreach ($parentChildren as $parentChild) {
                    //remove existing child
                    $parent->removeChild($parentChild);

                    //add cms menu, if before existing child
                    if ($page->getMenuAddType() == MenuAddType::BEFORE) {
                        if ($parentChild->getId() == $categoryNodeId) {
                            $this->addCmsPageToMenu($tree, $page, $parent);
                            $parent->setHasActive(true);
                        }
                    }

                    //return existing child
                    $parent->addChild($parentChild);

                    //add cms menu, if after existing child
                    if ($page->getMenuAddType() == MenuAddType::AFTER) {
                        if ($parentChild->getId() == $categoryNodeId) {
                            $this->addCmsPageToMenu($tree, $page, $parent);
                            $parent->setHasActive(true);
                        }
                    }
                }
            }
        }
    }

    /**
     * Get a collection of pages to be displayed in menu
     *
     * @return PageCollection
     * @throws NoSuchEntityException
     */
    private function getPageCollection()
    {
        $pageCollection = $this->pageCollectionFactory->create();
        $pageCollection->addFieldToFilter(PageInMenuInterface::IS_IN_MENU, 1);
        $pageCollection->addFieldToFilter(PageInterface::IS_ACTIVE, 1);
        $pageCollection->addStoreFilter($this->storeManager->getStore()->getId(), 1);

        return $pageCollection;
    }

    /**
     * Add CMS page to menu
     *
     * @param Node          $tree
     * @param PageInterface $page
     * @param Node          $parent
     *
     * @return void
     */
    private function addCmsPageToMenu($tree, $page, $parent)
    {
        $menuNodeData = $this->getMenuNodeData($page);

        if ($menuNodeData) {
            $cmsNode = $this->nodeFactory->create([
                'data' => $menuNodeData,
                'idField' => 'id',
                'tree' => $tree->getTree(),
                $parent
            ]);
            $parent->addChild($cmsNode);
        }
    }

    /**
     * Get data for menu node generation
     *
     * @param PageInterface $page
     *
     * @return array
     */
    private function getMenuNodeData($page)
    {
        $menuNodeData = [];
        if ($page->getIsInMenu()) {
            $isActive = $this->isPageActive($page->getId());

            $menuNodeData = [
                'name'      => $page->getMenuLabel() ?: $page->getTitle(),
                'id'        => 'cms-page-node-' . $page->getId(),
                'url'       => $this->pageHelper->getPageUrl($page->getId()),
                'is_active' => $isActive,
            ];
        }

        return $menuNodeData;
    }

    /**
     * Check if page is active in menu
     *
     * @param int $pageId
     *
     * @return bool
     */
    private function isPageActive($pageId)
    {
        $currentPageId = $this->registry->registry('current_cms_page_id');

        $isActive = false;
        if ($pageId == $currentPageId) {
            $isActive = true;
        }

        return $isActive;
    }
}
