<div id="mapReset" class="dropdown">

    <button type="button" class="p-0 mr-2 btn" title="Reset Map to Default Position">
        <span class="icon-wrapper">
        <i class="fas fa-sync noSelect"></i>
        </span>
    </button>

</div>

<button id="reloadAssetsBtn" type="button" title="Reload Assets and Geofences" class="p-0 mr-2 btn">
    <span class="icon-wrapper">
        <span class="icon-wrapper-bg"></span>
        <i class="fas fa-redo noSelect"></i>
    </span>
</button>

<button id="geoFenceToolsMenuNavBar" type="button" title="Toggle Geofence tools" class="p-0 mr-2 btn">
    <span class="icon-wrapper">
        <span class="icon-wrapper-bg"></span>
        <i class="fas fa-tools noSelect"></i>
    </span>
</button>

@component('components.map.assets')
@endcomponent

<button type="button" aria-haspopup="true" aria-expanded="false" title="Display the map settings" data-toggle="modal" data-target="#Settings" class="p-0 mr-2 btn">
    <span class="icon-wrapper">
        <span class="icon-wrapper-bg"></span>
        <i class="fas fa-sliders-h noSelect"></i>
    </span>
</button>