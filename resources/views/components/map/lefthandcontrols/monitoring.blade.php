<div class="main-card mb-3 card monitorOptions">
    <div class="card-body">
        <h5 class="card-title font-weight-bold text-center">Monitoring Options</h5>
        <form class="" autocomplete="off">
            <div class="position-relative form-group">
                <div id="refreshIntervalLabel">Update Interval: <span id="monitorRefreshInterval">5s</span></div>
                <div><input type="range" min="5" max="60" value="5" class="refreshIntervalSlider" oninput="UpdateSlider(this.value);"></div>
            </div>
        </form>
    </div>
    <div class="d-block text-right card-footer">
        <button id="alertVehicle" type="button" class="mt-1 btn btn-primary btn-sm" title="">Alert</button>
        <!-- <button id="disableVehicle" type="button" class="mt-1 btn btn-danger btn-sm" title="">Disable</button> -->
        <button id="reportStolen" type="button" class="mt-1 btn btn-danger btn-sm" title="">Report Stolen</button>
    </div>
</div>