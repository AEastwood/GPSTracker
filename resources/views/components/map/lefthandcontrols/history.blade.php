<div id="vehicleHistory" class="main-card mb-3 card vehicleHistory">
    <div class="card-body">
        <h5 class="card-title font-weight-bold text-center">Asset History</h5>
        <form class="" autocomplete="off">
            <div class="position-relative form-group">
                <div id="refreshIntervalLabel">Location: <span id="historyLocation"></span></div>
                <div id="refreshIntervalLabel">Time: <span id="historyTime"></span></div>
                <div id="refreshIntervalLabel">History Scroll:</div>
                <div> <input type="range" min="0" max="1" value="1" class="refreshIntervalSlider" oninput="UpdateSlider(this.value);"></div>
            </div>
        </form>
    </div>
    <div class="d-block text-right card-footer">
        <button id="geocodeHistoryLocation" type="button" class="mt-1 btn btn-primary btn-sm" title="">Geocode</button>
    </div>
</div>