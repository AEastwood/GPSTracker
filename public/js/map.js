/*  Adam Eastwood 2020
 *
 *   DEVELOPMENT SCRIPT
 *   VERSION:    1.0.3
 *
 */
$(document).ready(function() {
    csrf = $("input[name=_token]").val();

    $('#addActionToGeofence').click(function() {
        GeofenceActions();
    });

    $('#AddGeofenceActionBtn').click(function() {
        SaveGeofenceAction();
    });

    $('#alertVehicle').click(function() {
        AlertVehicle();
    });

    $('#assetSearchBox').on('keyup', function() {
        var searchTerm = ($('#assetSearchBox').val()) ? $('#assetSearchBox').val() : null;
        Search(searchTerm);
    });

    $('#assetSearchButton').click(function() {
        var searchTerm = ($('#assetSearchBox').val()) ? $('#assetSearchBox').val() : null;
        Search(searchTerm);
    });

    $('#closeAssetSearch').click(function() {
        $('.SearchContainer').toggle();
    });

    $('#closeVehicleInformation').click(function() {
        $('.vehicleInformation').hide();
        $('.vehicleHistory').hide();
    });

    $('#closeGeofenceTools').click(function() {
        GeofenceTools();
    });

    $('#darkModeToggle').click(function() {
        ChangeTheme();
    });

    $('#dangerzonesToggle').click(async function() {
        dangerzone = (!document.getElementById('dangerzonesToggle').checked) ? 0 : 1;
        SaveDagerzones(dangerzone);
        setTimeout(function() {
            ClearGeofences();
            LoadGeoFences();
        }, 200);

    });

    $('#disableVehicle').click(function() {
        DisableVehicle();
    });

    $('#geofenceColourPicker').change(function() {
        var colour = $('#geofenceColourPicker').val();
        setSelectedShapeColor(`#${colour}`);
    });

    $('#geoFenceToolsMenuNavBar').click(function() {
        GeofenceTools();
    });

    $('#LocateAsset').click(() => {
        TrackAsset();
    });

    $('#mapModeToggle').click(function() {
        map_mode = (!document.getElementById('mapModeToggle').checked) ? 0 : 1;
        SetMapMode();
        SaveMapMode();
    });

    $('#monitorVehicle').click(function() {
        Monitor();
    });

    $('#mapReset').click(function() {
        ResetView();
    });

    $('#newCircleButton').click(function() {
        NewGeofence('circle');
    });

    $('#newPolygonButton').click(function() {
        NewGeofence('polygon');
    });

    $('#newRectangleButton').click(function() {
        NewGeofence('rectangle');
    });

    $('#reloadAssetsBtn').click(function() {
        ClearGeofences();
        ReloadAssets();
        LoadGeoFences();
        toastr["success"]("Assets and Geofences have been reloaded successfully.", "Reloaded");
    });

    $('#saveGeofence').click(function() {
        SaveGeofence();
    });

    $('#vehicleHistory').click(function() {
        if (vehicleToMonitor.status === 0) {
            $('.vehicleHistory').toggle();
        }
    });

    $('#zoomToVehicle').click(function() {
        ZoomToActiveVehicle();
    });
});

$(window).resize(function() {
    ResizeMap();
});

const MainURL = "https://bus.adameastwood.com";
const IcoURI = `${MainURL}/imgs/ico`;

var activeVehicle,
    autoRefresh = true,
    autoRefreshTime = 60,
    csrf,
    defaultPosition = {
        lat: 54.242118,
        lng: -3.00000
    },
    defaultZoom = 6,
    geofenceActions = [],
    geofenceActionTitles = ['Enter', 'Leave', 'Exceeds Speed', 'Moves Before', 'Moves After'],
    geofenceActionResultTitles = ['Make API Call', 'Push Notification', 'Send Email', 'Send Text'],
    geoCoder,
    geoCoderResults = [],
    geofenceManager,
    geofenceMarkers = [],
    geofenceTools = false,
    map,
    monitorDelay = 10,
    monitorState = false,
    monitorVehicleTimer,
    selectedShape,
    vehicleMarker,
    vehicleMarkers = [],
    vehicleToMonitor = {
        status: false,
        id: null
    };


// Add Shape with appropriate event handlers
function AddShape(geofence, geofencedata) {
    var shape;

    switch (geofencedata.type) {
        case "circle":
            shape = new google.maps.Circle({
                name: geofence.name,
                dbState: true,
                uid: geofence.uid,
                dangerzone: geofence.dangerzone,
                type: geofencedata.type,
                stroke: '#fc0317',
                clickable: true,
                fillColor: geofence.colour,
                fillOpacity: 0.3,
                map: map,
                center: {
                    lat: parseFloat(geofencedata.center.lat),
                    lng: parseFloat(geofencedata.center.lng)
                },
                radius: parseFloat(geofencedata.radius)
            });
            break;

        case "polygon":
            var points = [];

            geofencedata.paths.forEach(path => {
                var point = {
                    lat: parseFloat(path.lat),
                    lng: parseFloat(path.lng),
                }
                points.push(point);
            });

            shape = new google.maps.Polygon({
                name: geofence.name,
                dbState: true,
                uid: geofence.uid,
                dangerzone: geofence.dangerzone,
                type: geofencedata.type,
                stroke: '#fc0317',
                clickable: true,
                fillColor: geofence.colour,
                fillOpacity: 0.3,
                map: map,
                paths: points
            });
            break;

        case "rectangle":
            var NE = geofencedata['bounds']['NE'],
                SW = geofencedata['bounds']['SW'];

            var NEPosition = JSON.parse(NE);
            var SWPosition = JSON.parse(SW);

            var LatLng = [
                NEPosition.lat, SWPosition.lng, SWPosition.lat, NEPosition.lng
            ];

            shape = new google.maps.Rectangle({
                name: geofence.name,
                dbState: true,
                uid: geofence.uid,
                dangerzone: geofence.dangerzone,
                type: geofencedata.type,
                stroke: '#fc0317',
                clickable: true,
                fillColor: geofence.colour,
                fillOpacity: 0.3,
                map: map,
                bounds: new google.maps.LatLngBounds(
                    new google.maps.LatLng(LatLng[0], LatLng[1]),
                    new google.maps.LatLng(LatLng[2], LatLng[3])
                )
            });
            break;
    }
    const setSelect = () => {
        setSelection(shape);
    }
    geofenceMarkers.push(shape);

    google.maps.event.addListener(shape, 'click', setSelect);
    google.maps.event.addListener(shape, 'radius_changed', setSelect);
    google.maps.event.addListener(shape, 'bounds_changed', setSelect);

    google.maps.event.addListener(geofenceManager, 'drawingmode_changed', clearSelection);
    google.maps.event.addListener(map, 'click', clearSelection);
    google.maps.event.addDomListener(document.getElementById('deleteGeofence'), 'click', DeleteGeofence);
}

// Alert the vehicle
function AlertVehicle() {
    alert(JSON.stringify(activeVehicle));
}

// Sends GET request and returns promise
async function APIRequestGET(URL) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: URL,
            complete: function(response) {

                switch (response.status) {
                    case 200:
                        resolve(response.responseText);
                        break;

                    default:
                        reject(response.responseText);
                        break;
                }
            }
        });
    });
}

// sends POST request and returns data as promise
async function APIRequestPOST(URL, data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: URL,
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data: data,
            dataType: "JSON",
            complete: function(response) {

                switch (response.status) {
                    case 200:
                        resolve(response.responseText);
                        break;

                    default:
                        reject(response.responseText);
                        break;
                }
            }
        });
    });
}

// starts the app
function AppStart() {
    ResizeMap();
    ScreenSize();
    initMap();
}

// Adds asset to asset list
function AssetListAdd(asset) {

    var assetName = null;
    var lastUpdate = LastUpdate(asset.updated_at);

    if (asset.type === 'boat') {
        assetName = `${asset.make} ${asset.model}`;
    } else {
        assetName = `${asset.make} ${asset.model} (${asset.registration})`;
    }

    $('#searchAssetsList').append(`
        <li class="list-group-item">
            <div class="todo-indicator ${lastUpdate.status}"></div>
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-2">
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-heading">${SanitiseInput(assetName)}</div>
                        <div class="widget-subheading"><i>Last update: ${lastUpdate.lastupdate}</i></div>
                    </div>
                    <div class="widget-content-right">
                        <button class="border-0 btn-transition btn btn-outline-light" onclick="SearchUID('${asset.uid}');" title="Goto ${SanitiseInput(assetName)}">
                            <i class="fas fa-map-marker-alt icon-gradient bg-asteroid"></i>
                        </button>
                    </div>
                </div>
            </div>
        </li>`);
}

// Auto refresh assets
function AutoRefresh() {
    let refresh;

    if (!autoRefresh) {
        clearTimeout(refresh);
    } else {
        ClearAssets();
        refresh = setTimeout(AutoRefresh, autoRefreshTime * 1000);
        LoadAssets();
    }
}

// Change Theme
function ChangeTheme() {
    let theme;
    userStyle = (!document.getElementById('darkModeToggle').checked) ? 0 : 1;

    UserUpdateTheme(userStyle);
    
    theme = {
        styles: GetTheme()
    };

    map.setOptions(theme);
}

// Returns empty string if input is empty
function CheckNull(input) {
    if (!input) return "";
    
    const upper = input.replace(/^\w/, function(chr) {
        return chr.toUpperCase();
    });

    return upper;
}

// Clear Selection
function clearSelection() {
    if (selectedShape) {
        if (selectedShape.type !== 'marker') {
            selectedShape.setEditable(false);

            DisableElements(['deleteGeofence', 'saveGeofence', 'addActionToGeofence']);
            MassNull(['geofenceName', 'geofenceColourPicker', 'geofenceCenter', 'circleRadiusSlider']);

            $('.geofenceAttributes').hide();
            $('.geofencePolygonShapeControls').hide();
            $('.geofenceCircleShapeControls').hide();
            $('.geofenceRectangleShapeControls').hide();
            $('#geofenceColourPicker').css('background-color', '#FFF');
            $('#geofenceNewButtons').show();
            $('.existingGeofenceButtons').hide();

        }

        selectedShape = null;
    }
}

// Clear Asset Markers
function ClearAssets() {
    vehicleMarkers.forEach(marker => {
        marker.setMap(null);
    });

    vehicleMarkers = [];
};

// Clears Geofences from the map
function ClearGeofences() {
    geofenceMarkers.forEach(geofence => {
        geofence.setMap(null);
    });

    geofenceMarkers = [];
    $('#myGeofencesTable > tbody > tr').remove();
}

// Delete Geofence
function DeleteGeofence(uid = null) {

    if (uid) {
        geofenceMarkers.forEach(marker => {
            if (marker != null) {
                if (marker.uid == uid) {
                    selectedShape = marker;
                }
            }
        });
    }

    if (!selectedShape) {
        toastr["error"]("There is no active geofence selected", "Error");
    }

    if (selectedShape.dbState) {
        var geofenceData = {
            'geofenceId': selectedShape.uid,
            'CSRF': csrf
        };

        APIRequestPOST('/geofence/delete', geofenceData).then((success, error) => {
            if (success) {
                toastr["success"]("The geofence has been deleted successfully", "Saved");
            } else if (error) {
                toastr["error"]("The geofence could not be deleted", "Failed");
            }
        });
    }

    selectedShape.setMap(null);

    geofenceMarkers.forEach((marker, i) => {
        if (marker != null) {
            if (selectedShape.uid == marker.uid) {
                geofenceMarkers[i] = null;
            }
        }
    });

    clearSelection();
    ListGeofences();

    DisableElements(['deleteGeofence', 'saveGeofence', 'addActionToGeofence']);
    MassHide(['geofencePolygonShapeControls', 'geofenceRectangleShapeControls', 'geofenceCircleShapeControls', 'geofenceAttributes', 'geofenceRadius']);
    MassNull(['geofenceName', 'geofenceColourPicker', 'geofenceCenter', 'circleRadiusSlider', 'geofenceRadius']);

    $('#geofenceColourPicker').css('background-color', '#FFF');
}

// Disables all elements provided through array
function DisableElements(elements) {
    elements.forEach(element => {
        $(`#${element}`).prop('disabled', true);
        $(`#${element}`).addClass('disabled');
    });
}

// Enables all elements provided through array
function EnableElements(elements) {
    elements.forEach(element => {
        $(`#${element}`).prop('disabled', false);
        $(`#${element}`).removeClass('disabled');
    });
}

// Geofence Actions
function GeofenceActions() {
    $('#geofenceNameActions').text(selectedShape.name);
}

// Geofence Tools
function GeofenceTools() {

    if (geofenceTools) {
        $('.geofenceControls').toggle();
        geofenceManager.setDrawingMode(null);
        clearSelection();
        geofenceTools = false;
        return;
    }

    geofenceManager.drawingControl = false;
    geofenceTools = true;
    $('.geofenceControls').show();

    geofenceManager.setMap(map);

    google.maps.event.addListener(geofenceManager, 'overlaycomplete', function(e) {
        var geofenceShape = e.overlay;
        geofenceShape.type = e.type;

        if (!geofenceShape.uid) {
            geofenceShape.uid = GetRandomString(16);
            geofenceShape.handler = false;
            geofenceShape.committed = false;
        }
        setSelection(geofenceShape);

        if (e.type !== google.maps.drawing.OverlayType.MARKER) {

            geofenceManager.setDrawingMode(null);
            google.maps.event.addListener(geofenceShape, 'click', function(e) {

                if (!geofenceShape.handler) {
                    const handlerFn = () => {
                        setSelection(geofenceShape)
                    };

                    google.maps.event.addListener(geofenceShape, 'click', handlerFn);
                    google.maps.event.addListener(geofenceShape, 'radius_changed', handlerFn);
                    google.maps.event.addListener(geofenceShape, 'bounds_changed', handlerFn);

                    google.maps.event.addListener(geofenceManager, 'drawingmode_changed', clearSelection);
                    google.maps.event.addListener(map, 'click', clearSelection);
                    google.maps.event.addDomListener(document.getElementById('deleteGeofence'), 'click', DeleteGeofence);
                    geofenceShape.handler = true;
                }


                if (e.vertex !== undefined) {

                    switch (geofenceShape.type) {

                        case google.maps.drawing.OverlayType.CIRCLE:
                            var path = geofenceShape.getPaths().getAt(e.path);
                            path.removeAt(e.vertex);

                            if (path.length < 3) {
                                geofenceShape.setMap(null);
                            }
                            break;

                        case google.maps.drawing.OverlayType.POLYGON:
                            var path = geofenceShape.getPath();
                            path.removeAt(e.vertex);

                            $('.geofencePolygonShapeControls').show();
                            $('#geofencePath').val(shape.getPath());

                            if (path.length < 2) {
                                geofenceShape.setMap(null);
                            }
                            break;

                        case google.maps.drawing.OverlayType.POLYLINE:
                            var path = geofenceShape.getPath();
                            path.removeAt(e.vertex);

                            if (path.length < 2) {
                                geofenceShape.setMap(null);
                            }
                            break;
                    }
                }
            });

            setSelection(geofenceShape);
        }
    });
}

// Generates random string with 'length' length
function GetRandomString(length) {
    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    for (var i = 0; i < length; i++) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }

    geofenceMarkers.forEach(marker => {
        if (marker.uid === result) {
            GetRandomString(16);
        }
    });

    return result;
}

// Send Get Request and return response
function GetRequest(GETURL) {
    $.ajax({
        type: "GET",
        url: GETURL,
        complete: function(data) {

            switch (data.status) {
                case 200:
                    return data.text;
            }
        }
    });
}

// Get Theme
function GetTheme() {
    return (userStyle === 0) ? MapStyleLight() : MapStyleDark();
}

// Hide Marker
function HideAsset(asset) {
    google.maps.event.addListener(asset, 'click', function() {
        marker.setVisible(false);
    });
}

// Function: Initialise the map
function initMap() {

    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: defaultPosition.lat,
            lng: defaultPosition.lng
        },
        disableDefaultUI: false,
        streetViewControl: false,
        fullscreenControl: false,
        mapTypeControl: false,
        mapTypeControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER
        },
        zoom: defaultZoom,
        styles: GetTheme()
    });

    geocoder = new google.maps.Geocoder;

    geofenceManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.HAND,
        drawingControl: false,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['circle', 'polygon', 'rectangle']
        },
        circleOptions: {
            fillColor: '#fc0317',
            fillOpacity: 0.25,
            strokeWeight: 3,
            zIndex: 2,
        },
        polygonOptions: {
            stroke: '#fc0317',
            fillColor: '#fc0317',
            strokeWeight: 3,
            zIndex: 2
        },
        rectangleOptions: {
            stroke: '#fc0317',
            fillColor: '#fc0317',
            strokeWeight: 3,
            zIndex: 2
        }
    });

    SetMapMode();
    map.addListener('click', function() {
        if (!vehicleToMonitor.status) {
            $('.vehicleInformation').hide();
        }
    });
    map.addListener('center_changed', function() {
        $('#mapReset').show();
    });
    map.addListener('zoom_changed', function() {
        $('#mapReset').show();
    });

    geofenceManager.addListener('overlaycomplete', (shape) => {
        shape.uid = GetRandomString(16);

        const newGeofence = {
            type: shape.type,
            name: `new ${shape.type}`,
            dbState: false,
            uid: shape.uid,
            stroke: '#fc0317',
            clickable: true,
            fillOpacity: 0.3,
            map: map,
            editable: false
        };

        geofenceMarkers.push(newGeofence);
        const setSelect = () => {
            setSelection(newGeofence);
        }

        google.maps.event.addListener(newGeofence, 'click', setSelect);
        google.maps.event.addListener(newGeofence, 'radius_changed', setSelect);
        google.maps.event.addListener(newGeofence, 'bounds_changed', setSelect);

        ListGeofences();
    });

    AutoRefresh();
    LoadGeoFences();
    LoadGeoFenceActions();
}

// Calculates last update time
function LastUpdate(lastUpdateTime) {
    var startDate = new Date(lastUpdateTime);
    var endDate = new Date();
    var seconds = (endDate.getTime() - startDate.getTime()) / 1000;

    if (seconds < 600) {
        return {
            status: "bg-success",
            lastupdate: moment(lastUpdateTime).fromNow()
        };
    } else if (seconds > 600 && seconds < 900) {
        return {
            status: "bg-warning",
            lastupdate: moment(lastUpdateTime).fromNow()
        };
    } else if (seconds > 900) {
        return {
            status: "bg-danger",
            lastupdate: moment(lastUpdateTime).fromNow()
        };
    }

}

//function lists geofences
function ListGeofences() {
    $('#myGeofencesTable > tbody > tr').remove();
    geofenceMarkers = geofenceMarkers.filter(geofence => geofence);

    geofenceMarkers.forEach(geofence => {
        const actions = `<button class="border-0 btn-transition btn btn-outline-light" onclick="SelectGeofence('${geofence.uid}');" title="Edit '${SanitiseInput(geofence.name)}'">
        <i class="fas fa-wrench icon-gradient bg-asteroid"></i></button>
        <button class="border-0 btn-transition btn btn-outline-light" onclick="DeleteGeofence('${geofence.uid}');" title="Delete '${SanitiseInput(geofence.name)}'">
        <i class="fas fa-times icon-gradient bg-asteroid"></i></button>`;

        if (!geofence.dangerzone) {
            $('#myGeofencesTable > tbody').append(`<tr><td>${SanitiseInput(geofence.name)}</td><td>${geofence.type}</td><td>${actions}</td></tr>`);
        }
    });
}

// Load Individual Asset
function LoadAsset(asset) {
    assetMarker = new google.maps.Marker({
        id: asset.id,
        position: new google.maps.LatLng(asset.lat, asset.lon),
        content: asset,
        icon: `${IcoURI}/${asset.type}.png`,
        map: map,
        zIndex: 1
    });

    if (vehicleToMonitor.status == true && AssetMarker.id === vehicleToMonitor.uid) {
        activeVehicle = asset;
        UpdateAssetAttributes();
        return;
    }

    AssetListAdd(asset);

    google.maps.event.addDomListener(assetMarker, 'click', function() {
        activeVehicle = asset;
        ToggleInformation();
        UpdateAssetAttributes();
    });

    vehicleMarkers.push(assetMarker);
}

// Load Assets, Add Asset Markers
function LoadAssets() {
    APIRequestGET(`${MainURL}/assets/loadall`).then((success, error) => {
        if (success) {
            Assets = JSON.parse(success);
            $("#searchAssetsList").empty();

            Assets.forEach(asset => {
                LoadAsset(asset);
            });
        } else {
            toastr['error']('Unable to load assets', 'Error');
        }
    });

}

// Loads geofences from the database
function LoadGeoFences() {
    APIRequestGET(`${MainURL}/geofence/loadall`).then((success, error) => {

        if (success) {
            const userShapes = JSON.parse(success);

            userShapes.DangerZones.forEach(dangerzone => {
                AddShape(dangerzone, JSON.parse(dangerzone.data));
            });

            userShapes.Geofences.forEach(geofence => {
                AddShape(geofence, JSON.parse(geofence.data));
            });

            ListGeofences();
        } else {
            toastr['error']("Unable to load Geofences", "Error");
        }
    });
}

// Loads geofences from the database
function LoadGeoFenceActions() {
    APIRequestGET(`${MainURL}/geofenceaction/loadall`).then((success, error) => {

        if (success) {
            const userGeofenceActions = JSON.parse(success);

            if (userGeofenceActions && userGeofenceActions.length > 0) {
                userGeofenceActions.forEach(action => {
                    geofenceActions.push(action);
                });
            }
        } else {
            toastr['error']("Unable to load Geofence Actions", "Error");
        }
    });
}

//function Manage Asset
function ManageAsset() {
    window.location.href = `/assets/${activeVehicle.uid}`;
}

// MassAssign: Assigns values via provided object
function MassAssign(elements) {
    for (var element in elements) {
        $(`.${element}`).text(elements[element]);
    }
}

// MassHide: Hides all selected elements
function MassHide(elements) {
    elements.forEach(element => {
        $(`#${element}`).hide();
    });
}

// MassNull: nulls values out via provided array
function MassNull(elements) {
    elements.forEach(element => {
        $(`#${element}`).val('');
    });
}

// Monitor Active Vehicle
function Monitor() {
    $('.vehicleHistory').hide();
    $('#monitorVehicle').toggleClass('btn-primary btn-danger');
    monitorState = (!monitorState) ? true : false;

    if (!monitorState) {
        $('.monitorOptions').hide();
        $('#monitorVehicle').text('Monitor').prop('title', 'Monitor the selected vehicle');
        clearInterval(monitorVehicleTimer);

        vehicleToMonitor = {
            status: false,
            id: null
        };
    } else {
        ZoomToActiveVehicle();
        $('.monitorOptions').show();
        $('#monitorVehicle').text('Stop').prop('title', 'Stop monitoring the selected vehicle');

        monitorVehicleTimer = setInterval(MonitorUpdate, monitorDelay * 1000);

        vehicleToMonitor = {
            status: true,
            id: activeVehicle.uid
        };
    }
}

// update event handler for monitoring
function MonitorUpdate() {
    ClearAssets();
    LoadAssets();
    ZoomToActiveVehicle();
    google.maps.event.trigger(activeVehicle, 'click');
}

// Sets drawing mode for new geofence
function NewGeofence(shape) {
    if (vehicleToMonitor.status) {
        toastr['error']("You cannot create a polygon whilst monitoring a vehicle", "Error");
        return;
    }

    switch (shape) {
        case "circle":
            geofenceManager.setDrawingMode(google.maps.drawing.OverlayType.CIRCLE);
            return;

        case "polygon":
            geofenceManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
            return;

        case "rectangle":
            geofenceManager.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);
            return;
    }
}

// Reload All Vehicle Markers
function ReloadAssets() {
    ClearAssets();
    LoadAssets();
}

// Reset Search
function ResetSearch() {
    $('#assetSearchBox').val('');
    Search();
}

// Reset View
function ResetView() {
    mapResetable = false;
    $('#mapReset').fadeOut(150);

    map.panTo(new google.maps.LatLng(defaultPosition.lat, defaultPosition.lng));
    map.setZoom(defaultZoom);
}

// Resize Map
function ResizeMap() {
    var mapSize = $(window).height() - 55;
    $("#map").height(mapSize);
}

// returns address
async function ReverseGeocode(lat = null, lng = null) {
    const location = {
        lat: (lat) ? lat : parseFloat(activeVehicle.lat),
        lng: (lng) ? lng : parseFloat(activeVehicle.lon)
    };

    return new Promise((resolve, reject) => {
        geocoder.geocode({
            'location': location
        }, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    geoCoderResults.push({
                        Date: new Date(),
                        VehicleID: activeVehicle.uid,
                        Lat: activeVehicle.lat,
                        Lng: activeVehicle.lon
                    });
                    resolve(results[0].formatted_address);
                } else {
                    reject('No Addresses Found');
                }
            } else {
                reject(`Unable to locate: ${status}`);
            }
        });
    });
}

// xss protection, also handled backend
function SanitiseInput(input) {
    return input.replace(/(<([^>]+)>)/ig, "")
}

// Updates dangerzone preference
function SaveDagerzones(dangerzone) {

    APIRequestGET(`${MainURL}/profile/updatedangerzone/${dangerzone}`);

    if (dangerzone === 0) {
        toastr["info"]("Dangerzones have been hidden. You will still be notified however Dangerzones will not be displayed on the map.", "Disabled");

    } else {
        toastr["info"]("Dangerzones are now visible. Everytime your asset enters a dangerzone you will receive a notification.", "Enabled");
    }
}

// Saves geofence to database
function SaveGeofence() {

    if (!selectedShape) {
        toastr["error"]("There is no active geofence selected", "Error");
        return;
    }

    if (selectedShape.dangerzone) {
        toastr["error"]("You are unable to save dangerzones", "Error");
    }

    var name = $("#geofenceName").val(),
        geofence;

    selectedShape.name = name;

    switch (selectedShape.type) {
        case "circle":
            geofence = {
                name: SanitiseInput(name),
                uid: selectedShape.uid,
                colour: `#${$("#geofenceColourPicker").val()}`,
                data: {
                    type: selectedShape.type,
                    center: {
                        lat: selectedShape.center.lat,
                        lng: selectedShape.center.lng
                    },
                    radius: selectedShape.radius
                },
            };
            break;

        case "polygon":
            let points = [];

            selectedShape.getPath().forEach(path => {
                const point = {
                    lat: path.lat(),
                    lng: path.lng()
                };
                points.push(point);
            });

            geofence = {
                name: name,
                uid: selectedShape.uid,
                colour: `#${$("#geofenceColourPicker").val()}`,
                data: {
                    type: selectedShape.type,
                    paths: points
                },
            };
            break;

        case "rectangle":
            var bounds = selectedShape.getBounds(),
                NE = bounds.getNorthEast(),
                SW = bounds.getSouthWest(),
                NEPosition = JSON.stringify(NE),
                SWPosition = JSON.stringify(SW);

            geofence = {
                "name": name,
                "uid": selectedShape.uid,
                "colour": `#${$("#geofenceColourPicker").val()}`,
                "data": {
                    "type": selectedShape.type,
                    "bounds": {
                        "NE": NEPosition,
                        "SW": SWPosition
                    }
                },
            };
            break;
    }

    var geofenceData = {
        'geofence': geofence,
        'CSRF': csrf
    };

    APIRequestPOST('/geofence/save', geofenceData).then((success, error) => {
        if (success) {
            toastr["success"]("The geofence has been successfully saved", "Saved");
        } else if (error) {
            toastr["error"]("The geofence could not be saved", "Failed");
        }
    });
}

// Saves geofence to database
function SaveGeofenceAction() {

    if (!selectedShape) {
        toastr["error"]("Unable to assign a geofence action to an invalid geofence", "Error");
    }

    var geofenceAction,
        geofenceAction = {
            'name': ($('#geofenceActionName').val()) ? $('#geofenceActionName').val() : GetRandomString(16),
            'shapeId': selectedShape.uid,
            'data': {
                'action': $('#GeofenceAction option:selected').attr('id'),
                'result': $('#GeofenceActionResult option:selected').attr('id')
            }
        },
        data = {
            'geofenceAction': geofenceAction
        };

    APIRequestPOST('/geofenceaction/save', data).then((success, error) => {
        if (success) {
            toastr["success"]("The geofence action has been successfully saved", "Saved");
            $('#geofenceActionsTable > tbody').append(`<tr><td>${SanitiseInput(geofenceAction.name)}</td><td>${geofenceActionTitles[geofenceAction.data.action - 1]}</td><td>${geofenceActionResultTitles[geofenceAction.data.result - 1]}</td></tr>`);
        } else if (error) {
            toastr["error"]("The geofence action could not be saved", "Failed");
        }
    });
}

// updates user map theme in the database
function SaveMapMode() {
    map_mode = (map_mode) ? map_mode : 0;

    APIRequestGET(`${MainURL}/profile/updatemapmode/${map_mode}`);
}

// checks and set template size according to resolution
function ScreenSize() {
    var screenSize = {
        "width": $(window).width(),
        "height": $(window).height()
    };

    var screenMode = (screenSize['width'] > 2200) ? "4k" : "1080";

    switch (screenMode) {
        case "1080":
            $('#leftHandContainer').toggleClass('col-lg-2 col-lg-3');
            $('#map').addClass('col-lg-9').removeClass('col-lg-10');
            return;

        case "4k":
            defaultZoom = 7;
            return;
    }
}

// Search
function Search(searchTerm) {
    if (!searchTerm) {
        LoadAssets();
        return;
    }

    const noResults = `<div style="padding: 10px 10px 10px 10px;"><div class="alert alert-warning fade show" role="alert">No matching assets found for ${SanitiseInput(searchTerm)}, <a href="#" onclick="ResetSearch();">Reset</a></div></div>`;

    var resultsCount = 0,
        searchArea = ['make', 'model', 'registration'],
        searchResults = [];

    vehicleMarkers.forEach(marker => {
        searchArea.forEach(param => {
            if (marker['content'][param].toLowerCase().includes(searchTerm.toLowerCase())) {

                if (!searchResults.find(vehicle => vehicle.uid == marker['content'].uid)) {
                    searchResults.push(marker['content']);
                    resultsCount++;
                }
            }
        })
    });

    if (resultsCount === 0) {
        $("#searchAssetsList").html(noResults);
        return;
    } else {
        $("#searchAssetsList").empty();

        searchResults.forEach(result => {
            AssetListAdd(result);
        });
    }

}

// Allows asset list to locate correct asset and zooms to it
function SearchUID(id) {
    var results = 0;

    if (!id)
        return;

    vehicleMarkers.forEach(marker => {
        if (marker['content'].uid == id) {
            activeVehicle = marker;
            results++;
        }
    });

    if (results > 0) {
        google.maps.event.trigger(activeVehicle, 'click');
        $('#vehicleInformation').show();
        ZoomToActiveVehicle();
    }

    if (results === 0) {
        swal("Not Found", "Unable to Find Vehicle", "info");
    }
}

// Selects geofence by uid
function SelectGeofence(uid) {
    geofenceMarkers.forEach(geofence => {
        if (geofence.uid === uid) {
            google.maps.event.trigger(geofence, 'click');
        }
    });
}

// Changes map display mode
function SetMapMode() {
    switch (map_mode) {
        case 0:
            $('#mapModeLabel').text('Map Mode (Roadmap)');
            map.setMapTypeId('roadmap');
            return;
        case 1:
            $('#mapModeLabel').text('Map Mode (Satellite)');
            map.setMapTypeId('satellite');
            return;
    }
}

// Set Geofence
function setSelection(shape) {
    if (shape.dangerzone) {
        toastr["warning"](`This is a Danger Zone. Should your asset enter this area a notification will automatically be sent.`, shape.name);
        return;
    }

    clearSelection();
    selectedShape = null;

    if (!geofenceTools) {
        toastr["info"](`In order to edit this geofence you must enable 'GeoFence Tools'`, "Hey");
        $("#geoFenceToolsMenuNavBar").fadeOut(150).fadeIn(150).fadeOut(150).fadeIn(150);
        return;
    }

    shape.setEditable(true);
    selectedShape = shape;

    $('#geofenceColourPicker').val(`${selectedShape.fillColor}`);
    $('#geofenceColourPicker').css('background-color', `${selectedShape.fillColor}`);
    $('.geofenceAttributes').show();
    $('#geofenceNewButtons').hide();
    $('.existingGeofenceButtons').show();

    $('#geofenceActionsTable > tbody > tr').remove();

    geofenceActions.forEach(action => {
        if (selectedShape.uid == action.geofence_uid) {
            let geofenceActionData = JSON.parse(action.data);
            $('#geofenceActionsTable > tbody').append(`<tr><td>${SanitiseInput(action.name)}</td><td>${geofenceActionTitles[geofenceActionData.action - 1]}</td><td>${geofenceActionResultTitles[geofenceActionData.result - 1]}</td></tr>`);
        }
    });

    switch (selectedShape.type) {
        case "circle":
            $('.geofenceCircleShapeControls').show();
            $('#geofenceName').val(shape.name)
            $('#geofenceCenter').val(shape.center);
            $('#geofenceRadius').val(shape.radius);
            break;

        case "rectangle":
            var bounds = selectedShape.getBounds(),
                NE = bounds.getNorthEast(),
                SW = bounds.getSouthWest();

            $('#polygonBoundsTable > tbody > tr').remove();
            $('.geofenceRectangleShapeControls').show();
            $('#geofenceName').val(shape.name)

            $('#polygonBoundsTable > tbody').append(`<tr><td>NE</td><td>${NE.lat()}</td><td>${NE.lng()}</td></tr>`);
            $('#polygonBoundsTable > tbody').append(`<tr><td>SW</td><td>${SW.lat()}</td><td>${SW.lng()}</td></tr>`);
            break;

        case "polygon":
            $('#polygonPathsTable > tbody > tr').remove();
            $('.geofencePolygonShapeControls').show();
            $('#geofenceName').val(shape.name);

            selectedShape.getPath().forEach((path, i) => {
                $('#polygonPathsTable > tbody').append(`<tr><td>${i + 1}</td><td>${path.lat()}</td><td>${path.lng()}</td></tr>`);
            });
            break;
    }

    EnableElements(['deleteGeofence', 'saveGeofence', 'addActionToGeofence']);
}

// Set Geofence Colour
function setSelectedShapeColor(color) {

    if (selectedShape) {
        if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
            selectedShape.set('strokeColor', color);
        } else {
            selectedShape.set('fillColor', color);
        }
    }
}

// Returns HTML if vehicle stolen or not
function Stolen(stolen) {
    var stolen = (stolen === 0) ?
        "<span class=\"label label-success\">No</span>" :
        "<span class=\"label label-danger\">Yes</span>";

    return stolen;
}

// Toggle Options Div
function ToggleInformation() {
    $('.controlsContainer').show();
}

// Reverse geocodes nearest address of asset
function TrackAsset() {
    ReverseGeocode().then((address, error) => {
        if (address) {
            alert(address);
        } else {
            alert(error);
        }
    });
}

// UpdateActiveState
function UpdateAssetAttributes() {
    $('.vehicleInformation').show();
    stolen = (activeVehicle.stolen) ? "Yes" : "No";

    var vehicle = {
        "makeModelSpan": CheckNull(`${activeVehicle.make} ${activeVehicle.model}`),
        "typeSpan": CheckNull(activeVehicle.type),
        "colourSpan": CheckNull(activeVehicle.colour),
        "registrationSpan": CheckNull(activeVehicle.registration),
        "positionCoordsSpan": CheckNull(`${activeVehicle.lat}, ${activeVehicle.lon}`),
        "positionAddrSpan": CheckNull(activeVehicle.addr),
        "speedSpan": CheckNull(`${activeVehicle.speed} mph`),
        "stolenSpan": CheckNull(`${stolen}`)
    };

    MassAssign(vehicle);
}

// Update Full Refresh
function UpdateRefresh(delayValue) {
    delayValue = (delayValue <= 5) ? 5 : delayValue;

    $('#updateTime').text(`(${delayValue}s)`);
    APIRequestGET(`${MainURL}/profile/updaterefresh/${delayValue}`);
}

// Update RefreshIntervalSlider
function UpdateSlider(delayValue) {
    var timeValue;
    delayValue = (delayValue <= 5) ? 5 : delayValue;
    monitorDelay = delayValue;

    clearInterval(monitorVehicleTimer);
    monitorVehicleTimer = setInterval(MonitorUpdate, monitorDelay * 1000);

    if (monitorDelay == 60) {
        timeValue = '1m';
    } else {
        timeValue = `${monitorDelay}s`;
    }

    $('#monitorRefreshInterval').text(timeValue);
}

// Update User Theme Preferences
function UserUpdateTheme(UserTheme) {
    APIRequestGET(`${MainURL}/profile/updatetheme/${UserTheme}`);
}

// Zoom to Vehicle
function ZoomToActiveVehicle() {
    var defaultZoom = 18;

    if (activeVehicle) {
        map.panTo(new google.maps.LatLng(activeVehicle.lat, activeVehicle.lon));

        if (map.getZoom() > defaultZoom) {
            return;
        }

        map.setZoom(defaultZoom);
    }

}