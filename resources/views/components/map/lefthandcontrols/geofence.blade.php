<!-- Geofence Controls -->
<div class="main-card mb-3 card geofenceControls">
    <div class="card-header"><i class="header-icon fas fa-draw-polygon icon-gradient bg-asteroid"> </i>Geofence Tools</div>

    <div class="card-body">

            <div id="geofenceNewButtons">
                <div class="selectNewGeofence noSelect"><h6>Choose one of the below options to add a new geofence</h6></div>

                <div class="grid-menu grid-menu-3col">
                    <div class="no-gutters row">
                        <div class="col-sm-6 col-xl-4">
                            <button id="newCircleButton" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                            <i class="fas fa-circle btn-icon-wrapper"> </i>New Circle
                            </button>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <button id="newPolygonButton" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                <i class="fas fa-star btn-icon-wrapper"> </i>New Polygon
                            </button>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <button id="newRectangleButton" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                            <i class="fas fa-square btn-icon-wrapper"></i>New Rectangle
                            </button>
                        </div>
                    </div>
                </div>
                <div class="selectExistingGeofence"><h6>Or simply click an existing geofence</h6></div>
                <table id="myGeofencesTable" class="mb-0 table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr></tr>
                            </tbody>
                        </table>
            </div>

            <div class="geofenceAttributes">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" id="geofenceName" placeholder="Geo-fence" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Colour</label>
                    <div class="col-sm-8">
                        <input type="text" value="#000" placeholder="#000" id="geofenceColourPicker" class="form-control jscolor" readonly>
                    </div>
                </div>
            </div>

            <!-- Circle -->
            <div class="geofenceCircleShapeControls">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Center</label>
                    <div class="col-sm-8">
                        <input type="text" value="" id="geofenceCenter" type="circle" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Radius (m)</label>
                    <div class="col-sm-8">
                    <input type="text" value="" id="geofenceRadius" type="circle" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <!-- /Circle -->

            <!-- Polygon -->
            <div class="geofencePolygonShapeControls">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Paths</label>
                </div>
                <div class="scroll-area-md">
                    <div class="scrollbar-container ps--active-y ps">
                        <table id="polygonPathsTable" class="mb-0 table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr></tr>
                            </tbody>
                        </table>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                    </div>
                </div>
                
                        
            </div>
            <!-- /Polygon -->

            <!-- Rectangle -->
            <div class="geofenceRectangleShapeControls">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Bounds</label>
                </div>
                <div class="scroll-area-sm">
                    <div class="scrollbar-container ps--active-y ps">
                        <table id="polygonBoundsTable" class="mb-0 table table-hover">
                            <thead>
                                <tr>
                                    <th>Heading</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Rectangle -->
    </div>

    <div class="d-block text-right card-footer">
        <div class="existingGeofenceButtons">
            <button id="addActionToGeofence" type="button" class="mt-1 btn btn-primary btn-sm disabled" title="Add an action" data-toggle="modal" data-target="#geofenceActions">Actions</button>
            <button id="deleteGeofence" type="button" class="mt-1 btn btn-danger btn-sm disabled" title="Delete the selected geo-fence">Delete</button>
            <button id="saveGeofence" type="button" class="mt-1 btn btn-success btn-sm disabled" title="Save the selected geo-fence">Save</button>
        </div>
        
    </div>
</div>