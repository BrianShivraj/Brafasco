<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Plugin\Api\SourceRepositoryInterface;

use Wyomind\StoreLocator\Api\Data\SourceInterface as SourceInterface;
/**
 * Class Save
 * @package Wyomind\StoreLocator\Plugin\Api\SourceRepositoryInterface
 */
class Save
{
    protected $imageUploader;
    /**
     * @var \Wyomind\StoreLocator\Model\ResourceModel\AttributesValues\CollectionFactory
     */
    protected $valuesCollectionFactory;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Wyomind\StoreLocator\Model\ResourceModel\AttributesValues\CollectionFactory $valuesCollectionFactory)
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        $this->imageUploader = $this->objectManager->create("Wyomind\\StoreLocator\\Model\\ImageUpload");
        $this->valuesCollectionFactory = $valuesCollectionFactory;
    }
    /**
     * @param \Magento\InventoryApi\Api\SourceRepositoryInterface $subject
     * @param \Magento\InventoryApi\Api\Data\SourceInterface $resultSource
     * @throws \Exception
     */
    public function afterSave(\Magento\InventoryApi\Api\SourceRepositoryInterface $subject) : void
    {
        $resultSource = $this->resultSource;
        if (!isset($this->request->getPost()["general"])) {
            $data["general"] = $resultSource->getData();
        } else {
            $data = $this->request->getPost();
        }
        $isAjax = $this->request->getParam("isAjax");
        if (!$isAjax) {
            try {
                if (!isset($subject->update)) {
                    $update = [];
                } else {
                    $update = $subject->update;
                }
                $update[SourceInterface::SOURCE_CODE] = $data["general"]["source_code"];
                $root = "/pub/media/";
                if (isset($data["general"]["image"])) {
                    //upload
                    if (is_array($data["general"]["image"])) {
                        if (isset($data["general"]["image"][0]["tmp_name"])) {
                            $this->imageUploader->moveFileFromTmp($data["general"]["image"][0]["name"]);
                            $update["image"] = $this->imageUploader->getBasePath() . $data["general"]["image"][0]["name"];
                        } elseif ($data["general"]["image"][0]["previewType"] == "image") {
                            $update["image"] = str_replace($root, "", $data["general"]["image"][0]["url"]);
                        }
                    } else {
                        $update["image"] = $data["general"]["image"];
                    }
                } else {
                    $resultSource->setImage(null);
                }
                $update["street_additional"] = $data["general"]["street_additional"];
                $update["display_order"] = (int) $data["general"]["display_order"];
                $update["business_hours"] = $data["general"]["business_hours"];
                $update["days_off"] = $data["general"]["days_off"];
                $update["store_ids"] = is_array($data["general"]["store_ids"]) ? implode(",", $data["general"]["store_ids"]) : $data["general"]["store_ids"];
                $update["customer_group_ids"] = is_array($data["general"]["customer_group_ids"]) ? implode(",", $data["general"]["customer_group_ids"]) : $data["general"]["customer_group_ids"];
                $update["use_config_description"] = $data["general"]["use_config_description"];
                $update["visible_in_storelocator"] = $data["general"]["visible_in_storelocator"];
                $update["enable_page"] = $data["general"]["enable_page"];
                $update["url_key"] = $data["general"]["url_key"];
                $update["use_config_page"] = $data["general"]["use_config_page"];
                $update["page"] = $data["general"]["page"];
                $this->source->setData($update)->save();
                $collection = $this->attributesRepository->list();
                foreach ($collection as $field) {
                    $attribute = $this->attributesRepository->get($field->getCode());
                    $valueAttribute = $this->valuesCollectionFactory->create();
                    $value = $valueAttribute->getBySourceId($data["general"]["source_code"], $attribute->getAtributeId())->getFirstItem();
                    if (isset($data["general"][$field->getCode()])) {
                        $additional = ["value_id" => $value->getValueId(), "attribute_id" => $attribute->getAtributeId(), SourceInterface::SOURCE_CODE => $data["general"]["source_code"], "value" => $data["general"][$field->getCode()]];
                        $this->attributesValues->setData($additional)->save();
                    }
                }
                unset($data);
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }
}