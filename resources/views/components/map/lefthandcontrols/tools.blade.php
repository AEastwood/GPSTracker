<div id="mapControls" class="main-card mb-3 card">

    <div class="dropdown-menu-header">
        <div class="dropdown-menu-header-inner bg-midnight-bloom">
            <div class="menu-header-image" style="background-image: url('{{ asset('/imgs/architect/dropdown-header/abstract2.jpg') }}');">
            </div>
            <div class="menu-header-content text-white">
                <h5 class="menu-header-title noselect">Map Tools</h5>
            </div>
        </div>
    </div>

    <div class="grid-menu grid-menu-xl grid-menu-3col">
        <div class="no-gutters row">

            <div class="col-sm-6 col-xl-4 pt-2">
                <button id="reloadAssetsBtn" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link" title="Reload Assets">
                    <i class="fas fa-sync icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                    Reload Assets
                </button>
            </div>

            <div class="col-sm-6 col-xl-4 pt-2">
                <button id="geoFenceToolsMenuNavBar" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link" title="Toggle Geofence Tools">
                    <i class="fas fa-draw-polygon icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                    GeoFence Tools
                </button>
            </div>

            <div class="col-sm-6 col-xl-4 pt-2">
                <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link sexyLink" data-toggle="modal" data-target="#Settings" title="Map Settings">
                    <i class="fas fa-sliders-h icon-gradient bg-asteroid btn-icon-wrapper btn-icon-lg mb-3"></i>
                    Map Settings
                </button>
            </div>
        </div>
    </div>
</div>