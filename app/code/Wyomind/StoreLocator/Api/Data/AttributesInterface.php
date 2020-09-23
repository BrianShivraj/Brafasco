<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */


/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Wyomind\StoreLocator\Api\Data;

/**
 * Interface AttributeValuesInterface
 * @package Wyomind\StoreLocator\Api\Data
 */
interface AttributesInterface
{

    /**
     *
     */
    const ATTRIBUTE_ID="attribute_id";
    /**
     *
     */
    const CODE="code";
    /**
     *
     */
    const LABEL="label";
    /**
     *
     */
    const TYPE="type";


    /**
     * @return int
     */
    public function getAtributeId(): int;

    /**
     * @param int $atributeId
     */
    public function setAtributeId(int $atributeId): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @param string $sourceCode
     */
    public function setCode(string $sourceCode): void;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param int $value
     */
    public function setLabel(int $value): void;

    /**
     * @return int
     */
    public function getType(): int;

    /**
     * @param int $type
     */
    public function setType(int $type): void;


}