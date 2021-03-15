/*
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

define(["jquery"], function ($) {
    "use strict";
    return {
        sources: [],
        map: null,
        markers: null,
        dirRenderer: null,
        myLatLng: null,
        myStore: null,
        infowindow: null,
        W_GP: null,
        myLocation: null,
        nbStoresToDisplay: 0,
        unitSystem: 0, // metric
        myPreferredStore: {
            status: false,
            duration: {
                text: null,
                value: null
            },
            distance: {
                text: null,
                value: null
            }
        },

        initialize: function (code) {
            var latlng = new google.maps.LatLng(0, 0);
            if (this.sources[0] !== undefined) {
                latlng = new google.maps.LatLng(this.sources[0].lat, this.sources[0].lng);
            }
            var myOptions = {
                zoom: 10,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.HYBRID,
                componentRestrictions: { country: 'CA' }

            };
            var pStore = this.getCookie("preferred_store");
            if (pStore !== null && pStore !== "") {
                pStore = $.parseJSON(pStore);
                this.myPreferredStore.status = true;
                this.myPreferredStore.id = pStore.id;
                this.myPreferredStore.index = this.getStoreIndexById(pStore.id);
                this.myPreferredStore.name = pStore.name;
            }
            this.map = new google.maps.Map(document.getElementById("map_canvas_storelocator"), myOptions);
            this.markers = [];
            this.setPlaces();
            this.geoLocation();

            setTimeout(
                function () {
                    if (this.W_GP.myAddress === null) {
                        this.displaySearch(true);
                    }

                }.bind(this), 10000
            );
            setTimeout(
                function () {

                    if (typeof code != "undefined") {
                        this.displayStore(this.getStoreIndexById(code));
                        this.getDirections(this.getStoreIndexById(code))
                    }
                }.bind(this), 2500);

        },

        geoLocation: function () {
            // Try W3C Geolocation (Preferred)
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    this.map.setCenter(initialLocation);
                    this.findPlace(null, initialLocation);
                }.bind(this), function () {
                    this.handleNoGeolocation(true);
                }.bind(this));
                // Try Google Gears Geolocation
            } else {
                this.handleNoGeolocation(false);
            }
            return false;
        },
        handleNoGeolocation: function (errorFlag) {
            this.displaySearch(errorFlag);
            var pStore = this.getCookie("preferred_store");
            var preferredStore = null;
            if (pStore !== null && pStore !== "") {
                preferredStore = $.parseJSON(pStore);
            }
            var index = 0;
            if (preferredStore !== null) {
                index = this.getStoreIndexById(preferredStore.id);
            }
            this.displayStore(index);
            this.updateList("*");
            this.setCookie("storelocator-sources", "");
        },
        displaySearch: function (error) {
            var msg = "";
            var value = "";
            if (error) {
                msg = "<span>" + this.W_GP.strings.unableToFindYourLocation + "<span><br/>";
                value = this.W_GP.strings.enterYourLocation;
            } else {
                msg = "<span class='tools-new-location'>" + this.W_GP.strings.setANewLocation + "<span>";
                value = this.W_GP.myAddress;
            }

            var myPlace = "<div>";
            myPlace += msg;
            myPlace += "<input id='geocoder' value='" + value + "' onfocus='this.value=\"\";' onblur='require([\"jquery\", \"storelocator\"], function($, storelocator) {storelocator.findPlace($(\"#geocoder\").attr(\"value\"), null);});'/>";
            myPlace += "<button onclick='require([\"jquery\", \"storelocator\"], function($, storelocator) {storelocator.findPlace($(\"#geocoder\").attr(\"value\"), null);});' value='" + this.W_GP.strings.findMe + "'>" + this.W_GP.strings.findMe + "</button>";
            $("#tools").html(myPlace);
        },
        displayMyAddress: function (myAddress) {
            var myPlace = "<div>";
            myPlace += "<span class='tools-location'>" + this.W_GP.strings.yourLocation + " : </span>";
            myPlace += "<span class='tools-address'><b>" + myAddress + "</b></span>";
            myPlace += "<span class='tools-buttons'>";
            myPlace += "<a href='javascript:void(0);' onclick='require([\"storelocator\"], function(storelocator) {storelocator.displaySearch(false);});'>" + this.W_GP.strings.changeMyLocation + "</a>";
            myPlace += "<a id='show-my-location' href='javascript:void(0);' onclick='require([\"storelocator\"], function(storelocator) {storelocator.displayLocation(storelocator.W_GP.myAddress,true);});'>" + this.W_GP.strings.showMyLocation + "</a>";
            myPlace += "</span>";
            myPlace += "<div>";
            $("#tools").html(myPlace);
        },
        convertRad: function (input) {
            return (Math.PI * input) / 180;
        },
        distance: function (lat_a_degre, lon_a_degre, lat_b_degre, lon_b_degre) {
            var R = 6378000; //Rayon de la terre en mètre
            var lat_a = this.convertRad(lat_a_degre);
            var lon_a = this.convertRad(lon_a_degre);
            var lat_b = this.convertRad(lat_b_degre);
            var lon_b = this.convertRad(lon_b_degre);
            var d = R * (Math.PI / 2 - Math.asin(Math.sin(lat_b) * Math.sin(lat_a) + Math.cos(lon_b - lon_a) * Math.cos(lat_b) * Math.cos(lat_a)));
            return d;
        },
        sortBy: function (a, b) {
            return (Math.round(a.distance) < Math.round(b.distance)) ? -1 : ((Math.round(a.distance) > Math.round(b.distance)) ? 1 : 0);
        },
        sortByAfter: function (a, b) {
            if (a.status == "ZERO_RESULTS" && b.status == "ZERO_RESULTS") {
                return 0;
            } else if (a.status == "ZERO_RESULTS") {
                return 1;
            } else if (b.status == "ZERO_RESULTS") {
                return -1;
            } else {
                return (Math.round(a.distance.value) < Math.round(b.distance.value)) ? -1 : ((Math.round(a.distance.value) > Math.round(b.distance.value)) ? 1 : 0);
            }
        },
        findPlace: function (myAddress, myAddress2) {
            this.closeDirection();
            var geocoder = new google.maps.Geocoder();
            var data = {};
            if (myAddress2 !== null) {
                data = {location: myAddress2};
            } else {
                data = {'address': myAddress};
            }
            if (myAddress == '') {
                this.geoLocation();
                return;
            }

            geocoder.geocode(data, function (results, status) {
                    if (this.dirRenderer !== null) {
                    this.dirRenderer.setMap(null);
                }
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        var coord = [results[0].geometry.location.lat(), results[0].geometry.location.lng()];
                        this.myLatLng = new google.maps.LatLng(coord[0], coord[1]);

                        $.each(this.stores, function (i) {
                            this.stores[i].distance = this.distance(coord[0], coord[1], this.stores[i].position.lat(), this.stores[i].position.lng());
                        }.bind(this));

                        var storeTemp = [];
                        storeTemp = this.stores.sort(this.sortBy);
                        var storeList = [];
                        this.storeListTemp = [];
                        var i = 0;
                        $.each(storeTemp, function (s) {
                            if (i < 25) {
                                this.storeListTemp.push(storeTemp[s]);
                                storeList.push(storeTemp[s].position);
                            }
                            i++;
                        }.bind(this));
                        if (storeList.length > 0) {
                            var service = new google.maps.DistanceMatrixService();
                            service.getDistanceMatrix({
                                origins: [this.myLatLng],
                                destinations: storeList,
                                travelMode: google.maps.TravelMode.DRIVING,
                                unitSystem: this.unitSystem == 0 ? google.maps.UnitSystem.METRIC : google.maps.UnitSystem.IMPERIAL,
                                avoidHighways: false,
                                avoidTolls: false
                            }, function (response, statusDistance) {
                                if (statusDistance === "OK") {
                                    this.getDistances(response);
                                } else {
                                    alert(this.W_GP.strings.distanceCalculationFailed + statusDistance);
                                }
                                myAddress = results[0].formatted_address;
                                this.W_GP.myAddress = results[0].formatted_address;
                                this.displayLocation(myAddress, false);
                                this.updateList("*");
                            }.bind(this));
                        } else {
                            myAddress = results[0].formatted_address;
                            this.W_GP.myAddress = results[0].formatted_address;
                            this.displayLocation(myAddress, false);
                            this.updateList("*");
                            this.setCookie("storelocator-sources", "");
                        }
                    } else {
                        alert(this.W_GP.strings.noResultFound);
                        this.setCookie("storelocator-sources", "");
                    }
                } else {
                    //alert(this.W_GP.strings.unableToFindYourLocation);
                    this.setCookie("storelocator-sources", "");
                }
            }.bind(this));
        },
        getStoreIndexById: function (id) {
            var i = 0;
            var index = null;
            $.each(this.sources, function (ind, p) {
                if (p.id === id) {
                    index = i;
                }
                i++;
            });
            return index;
        },
        getStoreIdByIndex: function (index) {
            var i = 0;
            var id = null;
            $.each(this.sources, function (ind, p) {
                if (i === index) {
                    id = p.id;
                }
                i++;
            });
            return id;
        },
        getDistances: function (response) {
            this.myStore = {
                status: false,
                duration: {
                    text: null,
                    value: null
                },
                distance: {
                    text: null,
                    value: null
                }
            };
            this.myPreferredStore = {
                status: false,
                duration: {
                    text: null,
                    value: null
                },
                distance: {
                    text: null,
                    value: null
                }
            };
            var s = 0;
            $.each(this.sources, function (i, p) {
                this.sources[s].status = false;
                this.sources[s].order = s + this.sources.length;
                this.sources[s].duration.value = null;
                this.sources[s].duration.text = null;
                this.sources[s].distance.value = null;
                this.sources[s].distance.text = null;
                $('.distance_' + this.sources[s].id).html('');
                s++;
            }.bind(this));
            s = 0;

            var resp = response.rows[0].elements;
            var resp2 = resp.sort(this.sortByAfter);


            var cookieSources = [];
            var first = true;
            $.each(resp2, function (s, e) {
                var index = this.getStoreIndexById(this.storeListTemp[s].id);
                this.sources[index].order = s;
                if (e.status !== "ZERO_RESULTS") {
                    if (first) {
                        $(document).trigger('nearest-store_found', this.sources[index], index);
                        first = false;
                    }

                    this.sources[index].status = true;
                    this.sources[index].duration.value = e.duration.value;
                    this.sources[index].duration.text = e.duration.text;
                    this.sources[index].distance.value = e.distance.value;
                    this.sources[index].distance.text = e.distance.text.replace(',', '.');

                    if (this.displayDistance == "1" && this.displayDuration == "1") {
                        $('.distance_' + this.storeListTemp[s].id).html(e.distance.text + ' - ' + e.duration.text);
                    } else if (this.displayDistance == "1") {
                        $('.distance_' + this.storeListTemp[s].id).html(e.distance.text);
                    } else if (this.displayDuration == "1") {
                        $('.distance_' + this.storeListTemp[s].id).html(e.duration.text);
                    } else {
                        $('.distance_' + this.storeListTemp[s].id).html('');
                    }
                    if (!this.myStore.status || e.distance.value < this.myStore.distance.value) {
                        this.myStore.status = true;
                        this.myStore.id = this.storeListTemp[s].id;
                        this.myStore.duration.value = e.duration.value;
                        this.myStore.duration.text = e.duration.text;
                        this.myStore.distance.value = e.distance.value;
                        this.myStore.distance.text = e.distance.text.replace(',', '.');
                        this.myStore.index = index;
                    }
                } else {
                    $('.distance_' + this.storeListTemp[s].id).html('');
                    this.sources[index].status = false;
                    this.sources[index].duration.value = null;
                    this.sources[index].duration.text = null;
                    this.sources[index].distance.value = null;
                    this.sources[index].distance.text = null;
                }

                if (this.sources[index].distance.value != null) {
                    cookieSources.push({
                        id: this.storeListTemp[s].id,
                        distance: this.sources[index].distance
                    });
                } else {
                    cookieSources.push({
                        id: this.storeListTemp[s].id
                    });
                }
                this.sources[index].addToCookie = true;
            }.bind(this));

            $.each(this.sources, function (i, p) {
                if (typeof this.sources[i].addToCookie == "undefined") {
                    cookieSources.push({
                        id: this.sources[i].id
                    });
                }
            }.bind(this));

            //if (typeof ClickNCollect === "undefined") {
            this.setCookie("storelocator-sources", JSON.stringify(cookieSources));
            //}
        },
        displayLocation: function (myAddress, myAddress2) {
            var blueIcon = new google.maps.MarkerImage("//www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png");
            if (this.myLocation === null) {
                this.myLocation = new google.maps.Marker({
                    position: this.myLatLng,
                    map: this.map,
                    icon: blueIcon

                });
                google.maps.event.addListener(this.myLocation, "click", function () {
                    this.displayLocation(myAddress, true);
                }.bind(this));
            } else {
                this.myLocation.setPosition(this.myLatLng);
            }
            if (this.myStore !== undefined) {
                this.updateInfoWindowContent();

                if (this.myPreferredStore.status) {
                    this.blindStore(this.myPreferredStore.index);
                } else if (this.myStore.status) {
                    this.blindStore(this.myStore.index);
                }

                if (!myAddress2) {
                    var zoom = 12 - Math.round((this.myStore.distance.value * 100 / 500000) * (12 / 100));
                    if (zoom < 4) {
                        zoom = 4;
                    }
                    this.map.setZoom(zoom);
                }
            }
            this.infowindow.open(this.map, this.myLocation);
            this.map.panTo(this.myLatLng);
            this.displayMyAddress(myAddress);
        },
        updateInfoWindowContent: function () {
            var preferredStore = $.parseJSON(this.getCookie("preferred_store"));
            if (preferredStore !== null) {
                var index = this.getStoreIndexById(preferredStore.id);
                this.myPreferredStore = this.sources[index];
                if (typeof this.myPreferredStore != "undefined") {
                    this.myPreferredStore.status = true;
                    this.myPreferredStore.name = preferredStore.name;
                    this.myPreferredStore.index = index;
                } else {
                    this.myPreferredStore = {
                        status: false,
                        duration: {
                            text: null,
                            value: null
                        },
                        distance: {
                            text: null,
                            value: null
                        }
                    };
                }
            }
            var content = "<h4><b>"
                + this.W_GP.strings.youAreHere
                + "</b></h4>";
            if (this.myPreferredStore !== undefined && this.myPreferredStore.status) {
                content +=
                    "<br/>"
                    + this.W_GP.strings.myPreferredStoreIs
                    + " <b><a href='javascript:void(0);' onclick='require([\"storelocator\"], function(storelocator) {storelocator.displayStore(" + this.myPreferredStore.index + ");});'/>"
                    + this.sources[this.myPreferredStore.index].name
                    + "</a></b>";
                if (this.myPreferredStore.distance.text !== null) {
                    content += "<br>" + this.myPreferredStore.distance.text
                        + " - "
                        + this.myPreferredStore.duration.text;
                }
                content += "<br><a href='javascript:void(0);' onclick='require([\"storelocator\"], function(storelocator) {storelocator.getDirections(null)});'>" + this.W_GP.strings.getDirections + "</a>"
                if (this.myStore.status) {
                    content += "<br/>";
                }
            }

            if (this.myStore.status && this.myStore.id != this.myPreferredStore.id) {
                content +=
                    "<br/>"
                    + this.W_GP.strings.theClosestStoreIs
                    + " <b><a href='javascript:void(0);' onclick='require([\"storelocator\"], function(storelocator) {storelocator.displayStore(" + this.myStore.index + ");});'/>"
                    + this.sources[this.myStore.index].name
                    + "</a></b><br> "
                    + this.myStore.distance.text
                    + " - "
                    + this.myStore.duration.text
                    + "<br><a href='javascript:void(0);' onclick='require([\"storelocator\"], function(storelocator) {storelocator.getDirections(null)});'>" + this.W_GP.strings.getDirections + "</a>"
            }
            this.infowindow.setContent(content);
            if (!this.myPreferredStore.status && !this.myStore.status) {
                this.infowindow.setContent("<h4><b>" + this.W_GP.strings.youAreHere + "</b></h4><br/><b>" + this.W_GP.strings.noStoreLocated + "</b>");
            }
        },
        displayStore: function (index) {
            var pStore = this.getCookie("preferred_store");
            if (pStore !== null && pStore !== "") {
                pStore = $.parseJSON(pStore);
                this.myPreferredStore = this.sources[this.getStoreIndexById(pStore.id)];
                if (typeof this.myPreferredStore !== "undefined") {
                    this.myPreferredStore.status = true;
                }
            }
            if (index !== null && typeof this.sources[index] !== "undefined") {
                var latlng = new google.maps.LatLng(this.sources[index].lat, this.sources[index].lng);
                this.map.panTo(latlng);
                var content = this.sources[index].title;
                if (this.sources[index].status && this.sources[index].distance.text !== null) {
                    content += "<br>"
                        + this.sources[index].distance.text
                        + " - "
                        + this.sources[index].duration.text
                        + " "
                        + this.W_GP.strings.from
                        + " "
                        + "<a href='javascript:void(0);' onclick='require([\"storelocator\"], function(storelocator) {storelocator.displayLocation(storelocator.W_GP.myAddress,true)});'>"
                        + this.W_GP.myAddress
                        + "</a><br>";
                    content += this.sources[index].links.directions + " | ";
                } else {
                    content += "<br/>";
                }
                content += this.sources[index].links.showOnMap;

                if ($('#map_canvas_storelocator.canSelectPreferredStore').length > 0) {
                    if (typeof this.myPreferredStore === "undefined" || typeof this.myPreferredStore !== "undefined" && this.myPreferredStore.id != this.sources[index].id) {
                        content += '<br/><a href="#" class="select-store choose_preferred_store" id="preferred_store_' + this.sources[index].id + '">' + this.W_GP.strings.selectStore + '</a>';
                    }
                }
                if (typeof this.myPreferredStore !== "undefined" && this.myPreferredStore.id === this.sources[index].id) {
                    content += "<br/><br/><span class='preferred'>" + this.W_GP.strings.myPreferredStore + "</span>";
                }

                this.infowindow.setContent(content);
                this.infowindow.open(this.map, this.markers[index]);
                this.blindStore(index);
            }
        },

        blindStore: function (index) {
            var id = this.getStoreIdByIndex(index);
            $("#storelocator_scroll .details[id!=place_" + id + "]").each(function () {
                $(this).hide(200);
            });
            $("#place_" + id).show(200);
            setTimeout(function () {
                $("#storelocator_scroll").animate({scrollTop: $("#storelocator_scroll").scrollTop() + ($('#' + id).offset().top - $("#storelocator_scroll").offset().top)});
            }, 300);

            $(document).trigger("store_selected_pos", id);
        },
        setPlaces: function () {
            this.stores = [];
            $.each(this.sources, function (i, p) {
                this.infowindow = new google.maps.InfoWindow();
                var latlng = new google.maps.LatLng(p.lat, p.lng);

                this.markers[i] = new google.maps.Marker({
                    position: latlng,
                    map: this.map,
                    id: p.id
                });
                google.maps.event.addListener(this.markers[i], "click", function () {
                    this.displayStore(this.getStoreIndexById(p.id));
                }.bind(this));
                this.stores.push({id: p.id, position: this.markers[i].position});
                i++;
            }.bind(this));
        },
        updateList: function (country) {
            if ($("#country_place").length) {
                if (typeof country != "undefined" && country !== null) {
                    $("#country_place").val(country);
                }
                $(".source").each(function () {
                    if ($("#country_place").attr("value") !== "*") {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
                if ($("#country_place").attr("value") !== "*") {
                    $("." + $("#country_place").attr("value")).each(function () {
                        $(this).show();
                    });
                }
            } else {
                $(".source").each(function () {
                    $(this).show();
                });
            }

            // reorder the POS according to the distance (using the "order" css rule)
            var elts = $('.source');
            var preferredStore = this.getCookie("preferred_store");
            if (preferredStore !== null && preferredStore !== null && preferredStore !== "") {
                preferredStore = $.parseJSON(preferredStore);
            } else {
                preferredStore = {id: -1};
            }
            elts.each(function (i) {
                var id = $(elts[i]).find("h3 > a").attr('id');
                var index = this.getStoreIndexById(id);
                $(elts[i]).css({"order": this.sources[index].order});
                if (preferredStore !== null && preferredStore.id == id) {
                    $(elts[i]).addClass('preferred');
                }
            }.bind(this));

            // only show the first x stores
            elts.each(function (i) {
                var order = $(elts[i]).css('order');

                if (this.nbStoresToDisplay > 0 && parseInt(order) >= this.nbStoresToDisplay) {
                    $(elts[i]).hide();
                }
            }.bind(this));

            $(document).trigger('pos_list_updated', [this]);

        },
        getDirections: function (index) {
            this.updateList("*");
            if (this.dirRenderer !== null) {
                this.dirRenderer.setMap(null);
            }
            var dirService = new google.maps.DirectionsService();
            this.dirRenderer = new google.maps.DirectionsRenderer({suppressMarkers: true, suppressInfoWindows: true});
            $("#directions").html("");
            var fromStr = this.W_GP.myAddress;
            var toStr = "";
            if (index === null) {
                toStr = this.sources[this.myStore.index].lat + "," + this.sources[this.myStore.index].lng;
            } else {
                toStr = this.sources[index].lat + "," + this.sources[index].lng;
            }
            var dirRequest = {
                origin: fromStr,
                destination: toStr,
                travelMode: google.maps.DirectionsTravelMode.DRIVING,
                unitSystem: google.maps.DirectionsUnitSystem.METRIC,
                provideRouteAlternatives: true
            };
            dirService.route(dirRequest, function (dirResult, dirStatus) {
                this.dirRenderer.setMap(this.map);
                $("#dirRendererBlock").show();
                this.dirRenderer.setPanel(document.getElementById("directions"));
                this.dirRenderer.setDirections(dirResult);
                this.infowindow.close();
            }.bind(this));
        },
        closeDirection: function () {
            if (this.dirRenderer !== null) {
                this.dirRenderer.setMap(null);
            }
            $("#directions").text("");
            $("#dirRendererBlock").hide();
        },
        getCookie: function (cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        setCookie: function (cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
    };
    });
