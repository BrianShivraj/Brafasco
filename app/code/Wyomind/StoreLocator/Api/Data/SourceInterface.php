<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Wyomind\StoreLocator\Api\Data;

/**
 * Represents physical storage, i.e. brick and mortar store or warehouse
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
 */
interface SourceInterface
{
    /**
     * SOURCE ID
     */
    const SOURCE_CODE='source_code_orig';
    /**
     *  Addtionnal Street field
     */

    const STREET_ADDITIONAL='street_additional';
    /**
     *  Image field
     */
    const IMAGE='image';
    /**
     *  Display Order field
     */
    const DISPLAY_ORDER='display_order';
    /**
     *  Business hours
     */
    const BUSINESS_HOURS='business_hours';
    /**
     * Days off
     */
    const DAYS_OFF='days_off';
    /**
     * PAge content
     */
    const PAGE="page";
    /**
     * Use the default description as defined in the configuration
     */
    const USE_CONFIG_DESCRIPTION="use_config_description";
    /**
     * Use the default template for the store page as defined in the configuration
     */
    const USE_CONFIG_PAGE="use_config_page";
    /**
     * Source visible in store locator
     */
    const VISIBLE_IN_STORELOCATOR="visible_in_storelocator";
    /**
     * Page is enabled
     */
    const ENABLE_PAGE="enable_page";
    /**
     * Source Page url key
     */
    const URL_KEY="url_key";


    /**
     * @return null|string
     */
    public function getStreetAdditional(): ?string;


    /**
     * @param null|string $streetAdditional
     */
    public function setStreetAdditional(?string $streetAdditional): void;


    /**
     * @return null|string
     */
    public function getImage(): ?string;


    /**
     * @param null|string $image
     */
    public function setImage(?string $image): void;


    /**
     * @return null|string
     */
    public function getDisplayOrder(): ?string;


    /**
     * @param null|string $displayOrder
     */
    public function setDisplayOrder(?string $displayOrder): void;


    /**
     * @return null|string
     */
    public function getBusinessHours(): ?string;

    /**
     * @param null|string $businessHour
     */
    public function setBusinessHours(?string $businessHour): void;


    /**
     * @return null|string
     */
    public function getPage(): ?string;


    /**
     * @param null|string $page
     */
    public function setPage(?string $page): void;

    /**
     * @return bool|null
     */
    public function getUseConfigDescription(): ?bool;

    /**
     * @return bool|null
     */
    public function getUseConfigPage(): ?bool;

    /**
     * @param bool|null $useConfigDescription
     */
    public function setUseConfigDescription(?bool $useConfigDescription): void;

    /**
     * @return bool|null
     */
    public function getVisibleInStorelocator(): ?bool;

    /**
     * @param bool|null $visibleInStorelocator
     */
    public function setVisibleInStorelocator(?bool $visibleInStorelocator): void;

    /**
     * @return bool|null
     */
    public function getEnablePage(): ?bool;

    /**
     * @param bool|null $enablePage
     */
    public function setEnablePage(?bool $enablePage): void;

    /**
     * @return null|string
     */
    public function getUrlKey(): ?string;

    /**
     * @param null|string $urlKey
     */
    public function setUrlKey(?string $urlKey): void;

    /**
     * @return null|string
     */
    public function getSourceCode(): ?string;

}
