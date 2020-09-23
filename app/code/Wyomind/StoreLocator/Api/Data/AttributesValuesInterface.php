<?php
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
interface AttributesValuesInterface
{
    /**
     *
     */
    const VALUE_ID="value_id";
    /**
     *
     */
    const ATTRIBUTE_ID="attribute_id";
    /**
     *
     */
    const SOURCE_CODE="source_code_orig";
    /**
     *
     */
    const VALUE="value";

    /**
     * @return int
     */
    public function getValueId(): ?int;

    /**
     * @param int $valueId
     */
    public function setValueId(?int $valueId): void;


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
    public function getSourceCode(): string;

    /**
     * @param string $sourceCode
     */
    public function setSourceCode(string $sourceCode): void;

    /**
     * @return string
     */
    public function getValue(): ?string;

    /**
     * @param int $value
     */
    public function setValue(string $value): void;


}