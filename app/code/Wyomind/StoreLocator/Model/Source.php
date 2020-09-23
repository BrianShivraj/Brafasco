<?php

namespace Wyomind\StoreLocator\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Wyomind\StoreLocator\Model\ResourceModel\Source as SourceResourceModel;

/**
 * Represents physical storage, i.e. brick and mortar store or warehouse
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
 */
class Source extends AbstractExtensibleModel implements \Wyomind\StoreLocator\Api\Data\SourceInterface
{


    /**
     *
     */
    public function _construct()
    {
        $this->_init(SourceResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getImage(): ?string
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @inheritdoc
     */
    public function setImage(?string $image): void
    {
        $this->setData(self::IMAGE, $image);
    }


    /**
     * @inheritdoc
     */
    public function getStreetAdditional(): ?string
    {


        return $this->getData(self::STREET_ADDITIONAL);
    }

    /**
     * @inheritdoc
     */
    public function setStreetAdditional(?string $streetAdditional): void
    {

        $this->setData(self::STREET_ADDITIONAL, $streetAdditional);
    }

    /**
     * @return null|string
     */
    public function getDisplayOrder(): ?string
    {
        return $this->getData(self::DISPLAY_ORDER);
    }

    /**
     * @param null|string $displayOrder
     */
    public function setDisplayOrder(?string $displayOrder): void
    {
        $this->setData(self::DISPLAY_ORDER, $displayOrder);
    }

    /**
     * @return null|string
     */
    public function getBusinessHours(): ?string
    {
        return $this->getData(self::BUSINESS_HOURS);
    }

    /**
     * @param null|string $businessHour
     */
    public function setBusinessHours(?string $businessHour): void
    {
        $this->setData(self::BUSINESS_HOURS, $businessHour);
    }

    /**
     * @return null|string
     */
    public function getDaysOff(): ?string
    {
        return $this->getData(self::DAYS_OFF);
    }

    /**
     * @param null|string $daysOff
     */
    public function setDaysOff(?string $daysOff): void
    {
        $this->setData(self::DAYS_OFF, $daysOff);
    }


    /**
     * @return null|string
     */
    public function getPage(): ?string
    {
        return $this->getData(self::PAGE);
    }

    /**
     * @param null|string $page
     */
    public function setPage(?string $page): void
    {
        $this->setData(self::PAGE, $page);
    }

    /**
     * @return bool|null
     */
    public function getUseConfigDescription(): ?bool
    {
        return $this->getData(self::USE_CONFIG_DESCRIPTION);
    }

    /**
     * @return bool|null
     */
    public function getUseConfigPage(): ?bool
    {
        return $this->getData(self::USE_CONFIG_PAGE);
    }

    /**
     * @param bool|null $useConfigDescription
     */
    public function setUseConfigDescription(?bool $useConfigDescription): void
    {
        $this->setData(self::USE_CONFIG_DESCRIPTION, $useConfigDescription);
    }

    /**
     * @return bool|null
     */
    public function getVisibleInStorelocator(): ?bool
    {
        return $this->getData(self::VISIBLE_IN_STORELOCATOR);
    }

    /**
     * @param bool|null $visibleInStorelocator
     */
    public function setVisibleInStorelocator(?bool $visibleInStorelocator): void
    {
        $this->setData(self::VISIBLE_IN_STORELOCATOR, $visibleInStorelocator);
    }

    /**
     * @return bool|null
     */
    public function getEnablePage(): ?bool
    {
        return $this->getData(self::ENABLE_PAGE);
    }

    /**
     * @param bool|null $enablePage
     */
    public function setEnablePage(?bool $enablePage): void
    {
        $this->setData(self::ENABLE_PAGE, $enablePage);
    }

    /**
     * @return null|string
     */
    public function getUrlKey(): ?string
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * @param null|string $urlKey
     */
    public function setUrlKey(?string $urlKey): void
    {
        $this->setData(self::URL_KEY, $urlKey);
    }


    /**
     * @return null|string
     */
    public function getSourceCode(): ?string
    {
        return $this->getData(self::SOURCE_CODE);
    }

    /**
     * @param $sourceCode
     */
    public function setSourceCode($sourceCode): void
    {
        $this->setData(self::SOURCE_CODE, $sourceCode);
    }
}