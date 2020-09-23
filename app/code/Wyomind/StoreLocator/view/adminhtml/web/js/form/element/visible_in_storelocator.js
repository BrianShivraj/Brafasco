/*
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

define([
    'jquery',
    'Magento_Ui/js/form/element/single-checkbox'
], function ($, checkbox) {
    'use strict';

    return checkbox.extend({

        initialize: function () {
            this._super();
            $(document).on('click', "div.fieldset-wrapper", function () {
                this.onUpdate(this.value());
            }.bind(this));

            return this;
        },

        /**
         *
         * @param value
         * @returns {*}
         */
        onUpdate: function (value) {

            if (value == 1) {

                $(".depends_visible_in_storelocator").each(function (i, elt) {
                    var use_config_description = $("INPUT[name='general[use_config_description]']").val();

                    if ($(elt).hasClass("depends_use_config_description") && use_config_description != 0) {


                        $(elt).hide();

                    }
                    else {


                        $(elt).show();
                    }
                })
            }
            else {
                $(".depends_visible_in_storelocator").each(function (i, elt) {

                    $(elt).hide();

                })
            }


            return this._super();
        },
    });
});