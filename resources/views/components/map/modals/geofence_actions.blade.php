<div class="modal fade" id="geofenceActions" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Geofence Actions - <span id="geofenceNameActions"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="addGeofenceAction">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" maxlength="64" id="geofenceActionName" placeholder="GeofenceAction-{{ rand(0, 9) }}" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Action</label>
                        <div class="col-sm-9">
                            <select id="GeofenceAction" class="form-control">
                                <option id="1" value="DAED">Enter</option>
                                <option id="2" value="DALD">Leave</option>
                                <option id="3" value="SPES">Exceeds Speed</option>
                                <option id="4" value="TIMB">Moves Before</option>
                                <option id="5" value="MA">Moves After</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Result</label>
                        <div class="col-sm-9">
                            <select id="GeofenceActionResult" class="form-control">
                                <option id="1">Make API Call</option>
                                <option id="2">Push Notification</option>
                                <option id="3">Send Email</option>
                                <option id="4">Send Text</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="existingGeofenceActions">
                    <table id="geofenceActionsTable" class="mb-0 table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="AddGeofenceActionBtn" type="button" class="btn btn-primary">Add Action</button>
            </div>
        </div>
    </div>
</div>