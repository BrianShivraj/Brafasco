define([
    'jquery',
    'mage/mage',
    'domReady!'
], function ($) {
    'use strict';

    // use custom js script here
    $('#header').mage('sticky', {
        container: '#maincontent',
        spacingTop: 0
    });
});
