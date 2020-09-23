<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Model;

class AttributesValues extends \Magento\Framework\Model\AbstractModel implements \Wyomind\StoreLocator\Api\Data\AttributesValuesInterface
{


    public function _construct()
    {
        $this->_init('Wyomind\StoreLocator\Model\ResourceModel\AttributesValues');
    }


    /**
     * @return int
     */
    public function getValueId(): ?int
    {
        return $this->getData(self::VALUE_ID);
    }

    /**
     * @param int $valueId
     */
    public function setValueId(?int $valueId): void
    {
        $this->setData(self::VALUE_ID, $valueId);
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
    public function getSourceCode(): string
    {
        return $this->getData(self::SOURCE_CODE);
    }

    /**
     * @param string $sourceCode
     */
    public function setSourceCode(string $sourceCode): void
    {
        $this->setData(self::SOURCE_CODE, $sourceCode);
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->getData(self::VALUE);
    }

    /**
     * @param int $value
     */
    public function setValue(string $value): void
    {
        $this->setData(self::VALUE, $value);
    }
}
