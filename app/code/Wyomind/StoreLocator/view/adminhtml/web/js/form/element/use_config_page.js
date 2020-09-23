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

            if (value == 0) {
                $(".depends_use_config_page").show();
            }
            else {
                $(".depends_use_config_page").hide();
            }


            return this._super();
        },
    });
});