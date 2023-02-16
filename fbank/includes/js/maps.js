function MyMap() {
    this.mapWrapperID = "map_canvas",
    this.tabClass = ".mod-locations-sidebar-filter",
    this.sideBarWrap = ".mod-locations-sidebar",
    this.sideBarItem = ".mod-locations-sidebar-list-item",
    this.sideBarLink = ".mod-location-sidebar-title",
    this.sideBarMore = ".mod-location-sidebar-collapsing",
    this.sideBarInfoLink = ".mod-location-sidebar-trigger",
    this.geocoder,
    this.map,
    this.oms,
    this.allBankLocations = {},
    this.startLat = 0.0,
    this.startLng = 0.0,
    this.startZoom = 15,
    this.$mapItemList,
    this.markers = [],
    this.displayType = "all",
    this.fadeOpacity = 0.5,
    this.latlngCenter = new window.google.maps.LatLng(35.054275400066366, -97.95822143554688);
}

MyMap.prototype.Initialize = function () {
    var me = this;
    me.AddEvents();
    me.GMapInit();
    me.GMapMarkers();
}
MyMap.prototype.AddEvents = function () {
    var me = this;
    $(me.tabClass).on("click", function () {
        var tabs = $(me.tabClass);
        for (var i = 0; i < tabs.length; i++) {
            if (tabs[i] != this && tabs[i].classList.contains("active")) {
                tabs[i].classList.remove("active");
            }
        }
        $(this).addClass("active");
        var value = $(this).data("action");
        switch (value) {
            case "all":
                $('[data-type]').show();
                break;
            case "bank":
                $('[data-type="atm"]').hide();
                $('[data-type="bank"],[data-type="bank-atm"]').show();
                break;
            case "atm":
                $('[data-type="bank"]').hide();
                $('[data-type="atm"],[data-type="bank-atm"]').show();
                break;
        }
        me.displayType = value;
        me.GMapDrawMarkers();
    });
    $(me.sideBarLink).on("click", function (e) {
        e.preventDefault();
        me.GMapClearSelected();
        var link = $(this);
        if (link.closest(me.sideBarItem).hasClass("active")) {
            $(link).next(me.sideBarMore).velocity("slideUp", {
                easing: 'swing',
                speed: 500,
                complete: function () {
                    link.closest(me.sideBarItem).removeClass("active");
                }
            })
        } else {
            // Slide up collapsible section that is not this
            /*$(me.sideBarItem + ".active").find(me.sideBarMore).velocity("slideUp", {
                easing: 'swing',
                speed: 500,
                complete: function () {
                    $(this).closest(".active").removeClass("active");
                }
            })*/
            $(link).next(me.sideBarMore).velocity("slideDown", {
                easing: 'swing',
                speed: 500,
                complete: function () {
                    link.closest(me.sideBarItem).addClass("active");
                    me.GMapFocusMarkerById($(link).closest(me.sideBarItem).data("id"), true);
                }
            })
        }
    });
    $(me.sideBarInfoLink).on("click", function () {
        var link = $(this);
        if (link.next(me.sideBarMore).hasClass("expanded")) {
            $(link).next(me.sideBarMore).velocity("slideUp", {
                easing: 'swing',
                speed: 500,
                complete: function () {
                    $(this).removeClass("expanded");
                }
            })
        } else {
            $(link).next(me.sideBarMore).velocity("slideDown", {
                easing: 'swing',
                speed: 500,
                complete: function () {
                    $(this).addClass("expanded");
                }
            })
        }
    });
}
MyMap.prototype.GMapInit = function () {
    var me = this;

    // the minimum zoom level that we'll allow
    var minZoomLevel = 6;

    var styles = [{
        featureType: "poi",
        stylers: [
			{ visibility: "off" }
        ]
    }];

    if (me.startLat != null && me.startLng != null && me.startLat != 0 && me.startLng != 0) {
        latlngCenter = new window.google.maps.LatLng(me.startLat, me.startLng);
    }

    //options passed to map
    var mapOptions = {
        center: latlngCenter,
        scrollwheel: false,
        streetViewControl: false,
        zoom: me.startZoom,
        minZoom: minZoomLevel,
        maxZoom: 16,
        navigationControl: true,
        styles: styles,
        mapTypeId: window.google.maps.MapTypeId.ROADMAP
    };

    // place the map on the page
    me.map = new window.google.maps.Map(document.getElementById(me.mapWrapperID), mapOptions);

    // Map Spidering
    me.oms = new OverlappingMarkerSpiderfier(me.map, { markersWontMove: true, nearbyDistance: 25, circleFootSeparation: 30 });

    //marker click
    me.oms.addListener('click', function (marker, event) {
        me.SideBarSelect(marker);
        me.GMapFocusMarker(marker);
        me.SideBarScrollTo(marker);
    });

    window.google.maps.event.addListener(me.map, "click", function (event) {
        me.CloseEvent();
    });

    me.oms.addListener('spiderfy', function (markers) {
        //me.CloseEvent();
    });
}
MyMap.prototype.CloseEvent = function () {
    var me = this;
    $(me.sideBarItem).css({ "opacity": 1 });
    var markers = me.oms.getMarkers();
    for (var i = 0; i < markers.length; i++) {
        var marker = markers[i];
        if (marker != null) {
            marker.setOpacity(1);
        }
    }
}
MyMap.prototype.SideBarSelect = function (marker) {
    var me = this;
    var target = $(me.sideBarItem + '[data-id="' + marker.data.ID + '"]');
    if (target.hasClass("active")) {

    }
    else {
        $(me.sideBarItem + ".active").find(me.sideBarMore).velocity("slideUp", { speed: 250, easing: 'swing', complete: function () { $(this).closest(".active").removeClass("active"); } });
        target.find(me.sideBarMore).velocity("slideDown", { speed: 250, easing: 'swing', complete: function () { target.addClass("active"); } });
    }
}
MyMap.prototype.SideBarScrollTo = function (marker) {
    var me = this;
    var id = marker.data.ID;
    var $target = $(me.sideBarItem + '[data-id="' + marker.data.ID + '"]');
    var top = $target.position().top + $(me.tabClass).first().parent().outerHeight();
    $(me.sideBarWrap).animate({ scrollTop: top }, 500, function () {
        //var lnk = $target.find(me.sideBarLink);
        //if (!lnk.hasClass("expanded")) {
        //    lnk.trigger("click");
        //}
    });
}

MyMap.prototype.GMapClearSelected = function () {
    var me = this;
    var markers = me.oms.getMarkers();
    for (var i = 0; i < markers.length; i++) {
        var marker = markers[i];
        if (marker != null) {
            marker.setOpacity(1);
        }
    }
}

MyMap.prototype.GMapFocusMarkerById = function (id, autoCenter) {
    var me = this;
    id = Number(id);
    if (isNaN(id)) return;
    var marker = null;
    var markers = me.oms.getMarkers();
    for (var i = 0; i < markers.length; i++) {
        if (markers[i].data.ID == id) {
            marker = markers[i];
        }
    }
    if (marker != null) me.GMapFocusMarker(marker, autoCenter);
}

MyMap.prototype.GMapFocusMarker = function (marker, autoCenter) {
    var me = this;
    me.GMapFadeMarkers();
    marker.setOpacity(1);
    if (autoCenter) me.map.setCenter(marker.getPosition());
}

MyMap.prototype.GMapFadeMarkers = function () {
    var me = this;
    var markers = me.oms.getMarkers();
    for (var i = 0; i < markers.length; i++) {
        var marker = markers[i];
        if (marker != null) {
            marker.setOpacity(me.fadeOpacity);
        }
    }
}

MyMap.prototype.GMapMarkers = function () {
    var me = this;
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < me.allBankLocations.length; i++) {
        var entity = me.allBankLocations[i];
        var latLng, size, scaledSize, markerZIndex;
        var origin = new window.google.maps.Point(0, 0),
			anchor = new window.google.maps.Point(16, 53);

        if (entity.Latitude != null && entity.Longitude != null && entity.marker == null) {
            latLng = new window.google.maps.LatLng(entity.Latitude, entity.Longitude);
            var iconUrl;
            if (entity.IsBank) {
                iconUrl = '/images/map-pin-largebank.png';
                size = new window.google.maps.Size(34, 48);
                scaledSize = new window.google.maps.Size(34, 48);
                markerZIndex = 99;
            } else {
                iconUrl = '/images/map-pin-atm-largebank.png';
                size = new window.google.maps.Size(34, 48);
                scaledSize = new window.google.maps.Size(34, 48);
                markerZIndex = 1;
            }

            var image = {
                url: me.getAbsoluteUrl(iconUrl),
                size: size,
                scaledSize: scaledSize,
                origin: origin,
                anchor: anchor
            };
            var imageOver = {
                url: me.getAbsoluteUrl(iconUrl),
                size: size,
                scaledSize: size,
                origin: origin,
                anchor: new window.google.maps.Point(32, 106)
            }
            var marker = new window.google.maps.Marker({
                position: latLng,
                visible: true,
                icon: image,
                title: entity.Title,
                zIndex: markerZIndex,
            });
            marker.data = entity;
            marker.origIcon = image;
            marker.overIcon = imageOver;
            me.markers.push(marker);
            me.oms.addMarker(marker);
            bounds.extend(marker.getPosition());
        }
    }
    me.map.fitBounds(bounds);
    me.GMapDrawMarkers();
}

MyMap.prototype.GMapDrawMarkers = function () {
    var me = this;
    for (var i = 0; i < me.markers.length; i++) {
        switch (me.displayType) {
            case "all":
                me.markers[i].setMap(me.map);
                break;
            case "bank":
                if (me.markers[i].data.IsBank) me.markers[i].setMap(me.map);
                else me.markers[i].setMap(null);
                break;
            case "atm":
                if (me.markers[i].data.IsAtm) me.markers[i].setMap(me.map);
                else me.markers[i].setMap(null);
                break;
        }
    }
}

MyMap.prototype.getAbsoluteUrl = function (relativeUrl) {
    var basePath = location.protocol + '//' + location.hostname + (typeof location.port !== 'undefined' && location.port != '' && location.port !== '80' ? ':' + location.port : '');
    return basePath + relativeUrl;
}

