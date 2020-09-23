<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Block\Adminhtml\Source\Edit;

class Hours extends \Magento\Backend\Block\Template
{
    /**
     * Block template.
     * @var string
     */
    protected $_template='source/edit/hours.phtml';

    /**
     * Prepare value list
     *
     * @return array
     */
    protected function prepareValues()
    {
        $values=[
            [
                'value'=>"Monday",
                'label'=>__('Monday')
            ],
            [
                'value'=>"Tuesday",
                'label'=>__('Tuesday')
            ],
            [
                'value'=>"Wednesday",
                'label'=>__('Wednesday')
            ],
            [
                'value'=>"Thursday",
                'label'=>__('Thursday')
            ],
            [
                'value'=>"Friday",
                'label'=>__('Friday')
            ],
            [
                'value'=>"Saturday",
                'label'=>__('Saturday')
            ],
            [
                'value'=>"Sunday",
                'label'=>__('Sunday')
            ]
        ];

        return $values;
    }

    /**
     * Retrieve HTML
     *
     * @return string
     */
    public function getElementHtml()
    {
        $values=$this->prepareValues();

        if (!$values) {
            return '';
        }
        $id="source";


        $html='<ul class="checkboxes business-hours">';

        foreach ($values as $day) {
            $html.='<li>';
            $html.='<div class="day-selector">';
            $html.='<label class="">'
                . '<input value="' . $day['value'] . '" '
                . 'class="' . $id . '_day " '
                . 'id="' . $day['value'] . '" '
                . 'type="checkbox" '
                . 'value="' . $day['value'] . '" />'
                . '<label for="' . $day['value'] . '">&nbsp;<b>' . $day['label'] . '</b></label>'
                . '</label>';

            $html.="<select   id='" . $day['value'] . "_open' class='hours_summary'>";
            for ($h=0; $h <= 24; $h++) {
                for ($m=0; $m < 60; $m=$m + 15) {
                    $html.="<option value='" . str_pad($h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($m, 2, 0, STR_PAD_LEFT) . "'>"
                        . str_pad($h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($m, 2, 0, STR_PAD_LEFT)
                        . "</option>";
                    if ($h == 24) {
                        break;
                    }
                }
            }
            $html.="</select> - ";
            $html.="<select  id='" . $day['value'] . "_close' class='hours_summary'>";
            for ($h=0; $h <= 24; $h++) {
                $selected=($h == 24) ? "selected " : "";
                for ($m=0; $m < 60; $m=$m + 15) {
                    $html.="<option " . $selected . "value='" . str_pad($h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($m, 2, 0, STR_PAD_LEFT) . "'>"
                        . str_pad($h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($m, 2, 0, STR_PAD_LEFT)
                        . "</option>";
                    if ($h == 24) {
                        break;
                    }
                }
            }
            $html.="</select>";
            $html.='</div>';

            $html.='<div class="lunch-selector">';
            $html.='<label class="">'
                . '<input value="' . $day['value'] . '" '
                . 'class="' . $id . '_lunch " '
                . 'id="' . $day['value'] . '_lunch" '
                . 'type="checkbox" '
                . 'value="' . $day['value'] . '_lunch" />'
                . '<label for="' . $day['value'] . '_lunch">&nbsp;<b>' . __("Lunch hours") . '</b></label>'
                . '</label>';

            $html.=" <select  id='" . $day['value'] . "_lunch_open' class='hours_summary'>";
            for ($h=0; $h <= 24; $h++) {
                for ($m=0; $m < 60; $m=$m + 15) {
                    $html.="<option value='" . str_pad($h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($m, 2, 0, STR_PAD_LEFT) . "'>"
                        . str_pad($h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($m, 2, 0, STR_PAD_LEFT)
                        . "</option>";
                    if ($h == 24) {
                        break;
                    }
                }
            }
            $html.="</select> - ";
            $html.="<select  id='" . $day['value'] . "_lunch_close' class='hours_summary'>";
            for ($h=0; $h <= 24; $h++) {
                $selected=($h == 24) ? "selected " : "";
                for ($m=0; $m < 60; $m=$m + 15) {
                    $html.="<option " . $selected . "value='" . str_pad($h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($m, 2, 0, STR_PAD_LEFT) . "'>"
                        . str_pad($h, 2, 0, STR_PAD_LEFT) . ':' . str_pad($m, 2, 0, STR_PAD_LEFT)
                        . "</option>";
                    if ($h == 24) {
                        break;
                    }
                }
            }
            $html.='</select>';
            $html.='</div>';
            $html.='</li>';
        }
        $html.='</ul>';

        return $html;
    }
}