<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Ui\Modifier\DataProvider;

use Magento\Backend\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\InventoryApi\Api\SourceRepositoryInterface;
use Magento\Ui\DataProvider\SearchResultFactory;
use Wyomind\StoreLocator\Api\Data\SourceInterface;
/**
 * Class SourceDataProvider
 * @package Wyomind\StoreLocator\Ui\Modifier\DataProvider
 */
class SourceDataProvider extends \Magento\InventoryAdminUi\Ui\DataProvider\SourceDataProvider
{
    /**
     * @var SourceRepositoryInterface
     */
    protected $sourceRepository;
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;
    /**
     * @var \Wyomind\StoreLocator\ImageUpload
     */
    protected $imageUploader;
    /**
     * @var \Magento\Framework\Filesystem\File\ReadInterface
     */
    protected $fileRead;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, string $name, string $primaryFieldName, string $requestFieldName, ReportingInterface $reporting, SearchCriteriaBuilder $searchCriteriaBuilder, RequestInterface $request, FilterBuilder $filterBuilder, SourceRepositoryInterface $sourceRepository, SearchResultFactory $searchResultFactory, Session $session, \Magento\Framework\Filesystem\File\ReadFactory $fileRead, array $meta = [], array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $reporting, $searchCriteriaBuilder, $request, $filterBuilder, $sourceRepository, $searchResultFactory, $session, $meta, $data);
        $this->sourceRepository = $sourceRepository;
        $this->imageUploader = $this->objectManager->create("Wyomind\\StoreLocator\\Model\\ImageUpload");
        $this->fileRead = $fileRead;
    }
    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        $data = parent::getData();
        if (self::SOURCE_FORM_NAME !== $this->name) {
            $previousId = null;
            foreach ($data["items"] as $k => $array) {
                $id = $data["items"][$k]["source_code"];
                $source = $this->sourceRepository->get($id);
                $sourceData = $source->getExtensionAttributes()->getSource()->getData();
                if (isset($sourceData[SourceInterface::SOURCE_CODE])) {
                    $currentId = $sourceData[SourceInterface::SOURCE_CODE];
                    if ($currentId != $previousId) {
                        foreach ($sourceData as $key => $value) {
                            $data["items"][$k][$key] = $value;
                        }
                        $image = $source->getExtensionAttributes()->getSource()->getImage();
                        unset($data["items"][$k]["image"]);
                        if ($image) {
                            $data["items"][$k]["image"][0]["name"] = $image;
                            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . DIRECTORY_SEPARATOR;
                            $data["items"][$k]["image"][0]["url"] = $mediaUrl . $image;
                            try {
                                $absolutePath = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
                                $file = $this->fileRead->create($absolutePath . $image, $this->fileDriver);
                                $data["items"][$k]["image"][0]["size"] = $file->stat()["size"];
                            } catch (\Exception $e) {
                            }
                        }
                        $previousId = $id;
                    }
                }
            }
            return $data;
        } elseif (self::SOURCE_FORM_NAME === $this->name) {
            if (!isset($data["totalRecords"])) {
                foreach ($data as $code => $array) {
                    $id = $data[$code]["general"]["source_code"];
                    $source = $this->sourceRepository->get($id);
                    foreach ($source->getExtensionAttributes()->getSource()->getData() as $key => $value) {
                        $data[$code]["general"][$key] = $value;
                    }
                    $image = $source->getExtensionAttributes()->getSource()->getImage();
                    unset($data[$code]["general"]["image"]);
                    if ($image) {
                        $data[$code]["general"]["image"][0]["name"] = $image;
                        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . DIRECTORY_SEPARATOR;
                        $data[$code]["general"]["image"][0]["url"] = $mediaUrl . $image;
                        try {
                            $absolutePath = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
                            $file = $this->fileRead->create($absolutePath . $image, $this->fileDriver);
                            $data[$code]["general"]["image"][0]["size"] = $file->stat()["size"];
                        } catch (\Exception $e) {
                        }
                    }
                    return $data;
                }
            }
        }
        return $data;
    }
}