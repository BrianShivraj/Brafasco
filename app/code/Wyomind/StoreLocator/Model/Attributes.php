<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Model;

class Attributes extends \Magento\Framework\Model\AbstractModel implements \Wyomind\StoreLocator\Api\Data\AttributesInterface

{


    public function _construct()
    {
        $this->_init('Wyomind\StoreLocator\Model\ResourceModel\Attributes');
    }


    /**
     * @return int
     */
    public function getAtributeId(): int
    {
        return $this->getData(self::ATTRIBUTE_ID);
    }

    /**
     * @param int $atributeId
     */
    public function setAtributeId(int $atributeId): void
    {
        $this->setData(self::ATTRIBUTE_ID, $atributeId);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->getData(self::CODE);
    }

    /**
     * @param string $sourceCode
     */
    public function setCode(string $sourceCode): void
    {
        $this->setData(self::CODE, $sourceCode);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getData(self::LABEL);
    }

    /**
     * @param int $value
     */
    public function setLabel(int $value): void
    {
        $this->setData(self::LABEL, $value);
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->setData(self::TYPE, $type);
    }
}
