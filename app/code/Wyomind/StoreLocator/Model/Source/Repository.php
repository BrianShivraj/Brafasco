<?php

namespace Wyomind\StoreLocator\Model\Source;

use Wyomind\StoreLocator\Api\Data\SourceInterface;
use Wyomind\StoreLocator\Api\SourceRepositoryInterface;
/**
 * Class Repository
 * @package Wyomind\StoreLocator\Model\Source
 */
class Repository implements SourceRepositoryInterface
{
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind)
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
    }
    /**
     * @param $code
     * @return SourceInterface
     */
    function get($code) : SourceInterface
    {
        $object = $this->sourceModel->load($code);
        return $object;
    }
    /**
     * @param $urlKey
     * @return SourceInterface
     */
    function getByUrlKey($urlKey) : SourceInterface
    {
        $object = $this->sourceModel->load($urlKey, "url_key");
        return $object;
    }
    /**
     * @param $code
     * @throws \Exception
     */
    function delete($code) : void
    {
        $this->sourceResourceModel->deleteSource($code);
    }
}