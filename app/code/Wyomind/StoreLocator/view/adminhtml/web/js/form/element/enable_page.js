/*
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

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
         * @param value
         *@returns {*}
         */
        onUpdate: function (value) {

            if (value == 1) {

                $(".depends_enable_page").each(function (i, elt) {
                    var use_config_page = $("INPUT[name='general[use_config_page]']").val();


                    if ($(elt).hasClass("depends_use_config_page") && use_config_page != 0) {
                        $(elt).hide();
                    }
                    else {
                        $(elt).show();
                    }
                })
            }
            else {
                $(".depends_enable_page").hide();
            }


            return this._super();
        },
    });
});