<?php

namespace Woom\CmsPagesInMenu\Plugin;

use Magento\Framework\Registry;
use Magento\Cms\Helper\Page;
use Magento\Framework\App\Action\Action;

class AddCurrentCmsToRegistry
{
    /**
     * Core registry
     *
     * @var Registry
     */
    private $registry;

    /**
     * AddCurrentCmsToRegistry constructor.
     *
     * @param Registry $registry
     */
    public function __construct(
        Registry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * During CMS page render, add page to registry
     *
     * @param Page   $subject
     * @param Action $action
     * @param int    $pageId
     *
     * @return array
     */
    public function beforePrepareResultPage(
        Page $subject,
        Action $action,
        $pageId
    ) {
        $this->registry->register('current_cms_page_id', $pageId);

        return [$action, $pageId];
    }
}
