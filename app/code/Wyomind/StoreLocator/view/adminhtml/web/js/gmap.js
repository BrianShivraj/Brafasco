/*
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */


define(["jquery"], function ($) {
    return {
        'Wyomind_StoreLocator_Gmap': function (config, component) {
            var latitude = $("INPUT[name='general[latitude]']").val();
            var longitude = $("INPUT[name='general[longitude]']").val();
            if (latitude === "") {
                latitude = "48.856951";
            }
            if (longitude === "") {
                longitude = "2.346868";
            }
            var zoom = 10;
            var LatLng = new google.maps.LatLng(latitude, longitude);
            var mapOptions = {
                zoom: zoom,
                center: LatLng,
                panControl: false,
                scaleControl: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(component, mapOptions);
            var marker = new google.maps.Marker({
                position: LatLng,
                map: map,
                title: "Drag Me!",
                draggable: true
            });
            google.maps.event.addListener(marker, "dragend", function (marker) {
                var latLng = marker.latLng;
                $("INPUT[name='general[longitude]']").val(latLng.lng().toFixed(6));
                $("INPUT[name='general[longitude]']").trigger("change");
                $("INPUT[name='general[latitude]']").val(latLng.lat().toFixed(6));
                $("INPUT[name='general[latitude]']").trigger("change");
            });
        }
    }
})