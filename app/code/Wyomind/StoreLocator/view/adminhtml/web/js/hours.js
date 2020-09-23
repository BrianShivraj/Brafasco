/*
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

define(["jquery"], function ($) {
    return {
        field:"INPUT[name='general[business_hours]']",
        initializeHours: function (id) {

            if ($(this.field).val() === "") {
                $(this.field).val("{}");
            }
            var data = JSON.parse($(this.field).val());

            for (var day in data) {
                $("#" + day).prop("checked", true);
                var time = data[day];
                $("#" + day + "_open").val(time.from);
                $("#" + day + "_close").val(time.to);
                if (typeof time.lunch_from !== "undefined") {
                    $("#" + day + "_lunch").prop("checked", true);
                    $("#" + day + "_lunch_open").val(time.lunch_from);
                    $("#" + day + "_lunch_close").val(time.lunch_to);
                } else {
                    $("#" + day + "_lunch").prop("checked", false);
                }
            }
            $('.' + id + "_day").each(function () {
                if (!$(this).prop("checked")) {
                    $(this).parent().parent().find("SELECT")[0].disabled = true;
                    $(this).parent().parent().find("SELECT")[1].disabled = true;
                }
            });
            $('.' + id + "_lunch").each(function () {
                $(this).prop("disabled", !$("#" + $(this).val()).prop("checked"));
                if (!$(this).prop("checked")) {
                    $(this).parent().parent().find("SELECT")[0].disabled = true;
                    $(this).parent().parent().find("SELECT")[1].disabled = true;
                }
            });

        },
        activeField: function (e, id) {
            var enabled = $(e).prop("checked");
            $(e).parent().parent().find("SELECT")[0].disabled = !enabled;
            $(e).parent().parent().find("SELECT")[1].disabled = !enabled;

            var lunch = $("#" + $(e).val() + "_lunch");
            lunch.prop("checked", false);
            lunch.prop("disabled", !enabled);
            lunch.parent().parent().find("SELECT")[0].disabled = true;
            lunch.parent().parent().find("SELECT")[1].disabled = true;
            this.summary(id);
        },
        activeFieldLunch: function (e, id) {
            $(e).parent().parent().find("SELECT")[0].disabled = !$(e).prop("checked");
            $(e).parent().parent().find("SELECT")[1].disabled = !$(e).prop("checked");
            this.summary(id);
        },
        summary: function (id) {
            var hours = {};
            $('.' + id + "_day").each(function (e) {
                if ($(this).prop("checked")) {
                    hours[$(this).val()] = {
                        from: $(this).parent().parent().find("SELECT")[0].value,
                        to: $(this).parent().parent().find("SELECT")[1].value
                    };
                }
            });
            $('.' + id + "_lunch").each(function (e) {
                if ($(this).prop("checked")) {
                    if (typeof hours[$(this).val()] === "undefined") {
                        hours[$(this).val()] = {};
                    }
                    hours[$(this).val()]['lunch_from'] = $(this).parent().parent().find("SELECT")[0].value;
                    hours[$(this).val()]['lunch_to'] = $(this).parent().parent().find("SELECT")[1].value;
                }
            });
            $(this.field).val(Object.toJSON(hours));
            $(this.field).trigger("change");
        }
    }
})
