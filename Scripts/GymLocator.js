var infowindowContent;
window.onload = function() {
    var infoWindow;
    infowindowContent = document.getElementById('infowindow-content');
    console.log(infowindowContent);
    var service;
    initMap();
}
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14
    });
    var gcoder = new google.maps.Geocoder();
    var address = "205 Humber College Blvd, Toronto, ON M9W 5L7";
    gcoder.geocode(
        { 'address': address },
        function(results, status) {
            if (status == 'OK') {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map
                });
            }
        }
    );

    searchForGyms(map);
    //searchForPlace(map);
    //new AutocompleteDirectionsHandler(map);
}

function searchForGyms(map) {
    infoWindow = new google.maps.InfoWindow();
    service = new google.maps.places.PlacesService(map);

    map.addListener('idle', performSearch);

    function performSearch() {
        var request = {
            bounds: map.getBounds(),
            keyword: "gym",
            location: map.getCenter(),
            radius: 2000,
            type: "gym"
        };
        service.nearbySearch(request, callback);
    }

    function callback(results, status) {
        if (status !== google.maps.places.PlacesServiceStatus.OK) {
            console.log(status);
            return;
        }
        for (var i = 0, result; result = results[i]; ++i) {
            addMarker(result);
        }
    }

    function addMarker(place) {
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            icon: {
                url: 'https://developers.google.com/maps/documentation/javascript/images/circle.png',
                anchor: new google.maps.Point(10, 10),
                scaledSize: new google.maps.Size(10, 17)
            }
        });

        google.maps.event.addListener(marker, 'click', function() {
            service.getDetails(place, function(result, status) {
                if (status  !== google.maps.places.PlacesServiceStatus.OK) {
                    console.log(status);
                    return;
                }
                infoWindow.setContent(infowindowContent);
                infowindowContent.children['place-name'].textContent = result.name;
                infowindowContent.children['place-address'].textContent = result.formatted_address;
                if (result.photos) {
                    infowindowContent.children['place-photo'].src = result.photos[0].getUrl({maxHeight: 50, minHeight: 50});
                } else {
                    infowindowContent.children['place-photo'].src = "../opt-imgs/favicon.png";
                }
                infowindowContent.children['add-gym-form'].children['place-name-input'].value = result.name;
                infowindowContent.children['add-gym-form'].children['place-address-input'].value = result.formatted_address;
                infowindowContent.children['add-gym-form'].children['place-lat-input'].value = result.geometry.location.lat();
                infowindowContent.children['add-gym-form'].children['place-lng-input'].value = result.geometry.location.lng();
                infoWindow.open(map, marker);
            });
        });
    }
}

function searchForPlace(map) {
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];

    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        markers.forEach(function(marker) {
            marker.setMap(null);
        });

        markers = [];

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };

            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
}

function AutocompleteDirectionsHandler(map) {
    this.map = map;
    this.originPlaceId = null;
    this.destinationPlaceId = null;
    this.travelMode = 'WALKING';

    var originInput = document.getElementById('origin-input');
    var destinationInput = document.getElementById('destination-input');
    var modeSelector = document.getElementById('mode-selector');
    this.directionsService = new google.maps.DirectionsService;
    this.directionsDisplay = new google.maps.DirectionsRenderer;
    this.directionsDisplay.setMap(map);

    var originAutocomplete = new google.maps.places.Autocomplete(
        originInput, {placeIdOnly: true});
    var destinationAutocomplete = new google.maps.places.Autocomplete(
        destinationInput, {placeIdOnly: true}); // types - gym. try latter
    
    this.setupClickListener('changemode-walking', 'WALKING');
    this.setupClickListener('changemode-transit', 'TRANSIT');
    this.setupClickListener('changemode-driving', 'DRIVING');

    this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
    this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destinationInput);
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
}

AutocompleteDirectionsHandler.prototype.setupClickListener = function(id, mode) {
    var radioButton = document.getElementById(id);
    var me = this;
    radioButton.addEventListener('click', function() {
        me.travelMode = mode;
        me.route();
    });
};

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
    var me = this;
    autocomplete.bindTo('bounds', this.map);
    autocomplete.addListener('place_changed', function(){
        var place = autocomplete.getPlace();
        if (!place.place_id) {
            window.alert("Please select an option from the dropdown list.");
            return;
        }
        if (mode === "ORIG") {
            me.originPlaceId = place.place_id;
        } else {
            me.destinationPlaceId = place.place_id;
        }
        me.route();
    });
};

AutocompleteDirectionsHandler.prototype.route = function() {
    if (!this.originPlaceId || !this.destinationPlaceId) {
        return;
    }
    var me = this;

    this.directionsService.route({
        origin: {'placeId': this.originPlaceId},
        destination: {'placeId': this.destinationPlaceId},
        travelMode: this.travelMode
    }, function(response, status) {
        if (status === "OK") {
            me.directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
};