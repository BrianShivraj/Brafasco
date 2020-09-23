<?php

/* *
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Ui\Component\Form;

/**
 * Class Attribute
 * @package Wyomind\StoreLocator\Ui\Component\Form
 */
class Attribute extends \Magento\Ui\Component\Form\Fieldset
{
    /**
     * @var \Magento\Ui\Component\Form\FieldFactory|null
     */
    protected $fieldFactory = null;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Magento\Framework\View\Element\UiComponent\ContextInterface $context, \Magento\Ui\Component\Form\FieldFactory $fieldFactory, array $components = [], array $data = [])
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($context, $components, $data);
        $this->fieldFactory = $fieldFactory;
    }
    /**
     * @return \Magento\Framework\View\Element\UiComponentInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getChildComponents()
    {
        $collection = $this->repository->list();
        foreach ($collection as $field) {
            $fieldInstance = $this->fieldFactory->create();
            switch ($field->getType()) {
                case 0:
                    $type = "textarea";
                    break;
                case 1:
                    $type = "wysiwyg";
                    break;
                default:
                    $type = "input";
                    break;
            }
            //
            $fieldInstance->setData(['config' => ['label' => $field->getLabel(), "dataType" => "text", "dataScope" => $field->getCode(), 'formElement' => $type, "template" => "ui/form/field", "wysiwygConfigData" => ["height" => "100", "add_variables" => true, "add_widgets" => false, "add_images" => true, "add_directives" => true], "formElements" => ["class" => "\\Magento\\Ui\\Component\\Form\\Element\\Wysiwyg"], "rows" => 8, "wysiwyg" => true], 'name' => $field->getCode()]);
            $fieldInstance->prepare();
            $this->addComponent($field->getCode(), $fieldInstance);
        }
        return parent::getChildComponents();
    }
}