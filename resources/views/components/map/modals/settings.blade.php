<div class="modal fade" id="Settings" tabindex="5" role="dialog" aria-labelledby="settingsModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Map Settings</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="row pb-2">
                    <div class="col-md-6">
                        Auto Refresh (?)
                    </div>
                    <div class="col-md-6">
                        <label class="switch float-right">
                            <input id="autoRefreshToggle" type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="row pb-2">
                    <div class="col-md-6">
                        Danger Zones (?)
                    </div>
                    <div class="col-md-6">
                        <label class="switch float-right">
                        @if(Auth::user()->dangerzones === 0) 
                            <input id="dangerzonesToggle" type="checkbox">
                            @else 
                            <input id="dangerzonesToggle" type="checkbox" checked>
                            @endif
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="row pb-2">
                    <div class="col-md-6">
                        Dark Mode (?)
                    </div>
                    <div class="col-md-6">
                        <label class="switch float-right">
                            @if(Auth::user()->theme === 0) 
                            <input id="darkModeToggle" type="checkbox">
                            @else 
                            <input id="darkModeToggle" type="checkbox" checked>
                            @endif
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="row pb-2">
                    <div class="col-md-6">
                        <span id="mapModeLabel" class="mapModeLabel">Map Mode 
                        @if(Auth::user()->map_mode === 0) 
                        (Roadmap)
                        @else 
                        (Satellite)
                        @endif
                        </span>
                    </div>
                    <div class="col-md-6">
                        <label class="switch float-right">
                            @if(Auth::user()->map_mode === 0) 
                            <input id="mapModeToggle" type="checkbox">
                            @else 
                            <input id="mapModeToggle" type="checkbox" checked>
                            @endif
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="row pb-2">
                    <div class="col-md-6">
                        Update Interval <span id="updateTime">({{ Auth::user()->refreshtime }}s)</span>
                    </div>
                    <div class="col-md-6 float-right">
                        <input type="range" min="5" max="60" value="{{ Auth::user()->refreshtime }}" class="refreshIntervalSlider" oninput="UpdateRefresh(this.value);">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>