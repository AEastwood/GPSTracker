<div class="main-card mb-3 card vehicleInformation">

    <div class="card-header"><i class="header-icon fas fa-car icon-gradient bg-asteroid"></i>Asset Information
        <div class="btn-actions-pane-right actions-icon-btn">
        </div>
    </div>

    <div class="card-body">

        <table style="width:100%">
            <tbody>
                <tr><td style="width: 35%"> <b>Make/Model</b> </td><td> <span style="width: 65%" class="makeModelSpan"></span> </td></tr>
                <tr><td> <b>Type</b> </td><td> <span class="typeSpan"></span> </td></tr>
                <tr><td> <b>Colour</b> </td><td> <span class="colourSpan"></span> </td></tr>
                <tr><td> <b>Registration</b> </td><td> <span class="registrationSpan"></span> </td></tr>
                <tr><td> <b>Position (Lat, Lng)</b> </td><td> <span class="positionCoordsSpan"></span> </td></tr>
                <tr><td> <b>Speed</b> </td><td> <span class="speedSpan"></span> </td></tr>
                <tr><td> <b>Stolen</b> </td><td> <span class="stolenSpan"></span> </td></tr>
            </tbody>
        </table>
    </div>

    <div class="d-block text-right card-footer">
        <button id="manageAsset" type="button" class="mt-1 btn btn-warning btn-sm" title="Manage your asset" onclick="ManageAsset();">Manage</button>
        <button id="LocateAsset" type="button" class="mt-1 btn btn-info btn-sm" title="Reverse Geocode the asset">Locate</button>
        <button id="monitorVehicle" type="button" class="mt-1 btn btn-primary btn-sm" title="Monitor the selected vehicle">Monitor</button>
        <button id="zoomToVehicle" type="button" class="mt-1 btn btn-primary btn-sm" title="Zoom to the selected vehicle">Zoom</button>
    </div>
</div>