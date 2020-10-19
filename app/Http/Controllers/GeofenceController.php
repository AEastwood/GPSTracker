<?php

namespace App\Http\Controllers;

use App\Notifications\AccountLimit;
use App\Notifications\GeofenceActivation;
use App\Geofence;
use App\GeofenceAction;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Auth;
use DB;
use response;
use Str;

class GeofenceController extends Controller
{
    // returns all geofences for the account
    public function AllGeofences(){

        $dangerzones = ( Auth::user()->dangerzones )
            ? $dangerzones = self::DangerZones()
            : [];

        $myGeofences = Geofence::where('ownerId', Auth::user()->id)->get();

        $response = new \stdClass();
        $response->DangerZones = $dangerzones;
        $response->Geofences = $myGeofences;

        return response()->json($response);
    }

    // returns all geofence actions for the account
    public function AllGeofenceActions(){
        $myGeofences = GeofenceAction::where('ownerId', Auth::user()->id)->get();

        return $myGeofences;
    }

    // returns true if UID is owned by user
    private function CheckUIDIsOwnedAndCanBeUsed($uid) {
        if ( Geofence::where('uid', $uid)->exists() ) {
            $isOwned = Geofence::where('uid', $uid)->first();

            if($isOwned->ownerId != Auth::user()->id)
                return false;
        }

        return true;
    }

    // Creates random name
    private static function CreateRandomName($prepend, $input) {
        $actionName = (isset($input))
            ? $input
            : "$prepend#" . rand(1000, 9999);

        return $actionName;
    }

    // returns known "dangerzones"
    private function DangerZones() {
        $dangerzones = DB::table('danger_zones')->select('uid', 'colour', 'dangerzone', 'data', 'name', 'type')->where('disabled', false)->get();

        return $dangerzones;
    }

    // deletes a geofence in the database
    public function DeleteGeofence(Request $request) {
        $deleted = Geofence::where('uid', $request->geofenceId)->where('ownerId', Auth::user()->id)->delete();
        dd(self::DeleteAssociatedGeofenceActions($request->geofenceId));

        return response(200);
    }

    // deletes all actions when geofence is deleted
    private function DeleteAssociatedGeofenceActions($uid) {
        $deleted = GeofenceAction::where('geofence_uid', $uid)->where('ownerId', Auth::user()->id)->delete();

        return $deleted;
    }

     // deletes a geofence in the database
    public function DeleteGeofenceAction(Request $request) {
        $deleted = GeofenceAction::where('uid', $uid)->where('ownerId', Auth::user()->id)->delete();

        return $response;
    }

    // returns array of objects - users geofences
    public static function GeofenceActions($geofenceUID) {
        $geofenceActions =  GeofenceAction::where('geofenceId', $geofenceUID)->where('ownerId', Auth::user()->id)->get();

        return $response;
    }

    /**
    *   Saves Geofences to Database
    *   @param [Request]
    */
    public function SaveGeoFence(Request $request) {

        SubscriptionController::LimitCheck([
            'geofence'
        ]);

        $expectedTypes = ['circle', 'polygon', 'rectangle'];
        $request = new Request($request->geofence);

        $request->validate([
            'name' => 'nullable',
            'uid' => 'nullable',
            'ownerId' => 'integer',
            'colour' => 'string',
            'data' => 'required'
        ]);

        $uid = (isset($request->uid)) ? $request->uid : Str::random(16);

        $response = (Geofence::UpdateOrCreate([
            'uid'       => $uid,
            'ownerId'   => Auth::user()->id
        ],[
            'name'      => self::CreateRandomName("Geofence", $request->name),
            'colour'    => str_replace('##', '#', $request->colour),
            'data'      => json_encode($request->data),
            'ownerId'   => Auth::user()->id
        ]))
            ? response()->json([ 'status' => 'geofence has been saved' ], 200)
            : response()->json([ 'status' => 'geofence could not be saved' ], 500);

        return $response;
    }

    /*
    *   Saves Geofence Actions to Database
    *   @param $geofenceAction
    */
    public function SaveGeofenceAction(Request $request) {

        SubscriptionController::LimitCheck([
            'geofenceaction'
        ]);

        $request = new Request($request->geofenceAction);

        $request->validate([
            'name' => 'nullable',
            'shapeId' => 'required|string',
            'data' => 'required|array'
        ]);
        
        $uid = (isset($request->uid)) ? $request->uid : Str::random(16);
            
        $response = (GeofenceAction::UpdateOrCreate([
            'uid'           => $uid,
            'ownerId'       => Auth::user()->id
        ],
        [
            'name'          => self::CreateRandomName("GeofenceAction", $request->name),
            'geofence_uid'  => Geofence::where('uid', $request->shapeId)->select('uid')->first()->uid,
            'data'          => json_encode($request->data),
            'ownerId'       => Auth::user()->id

        ]))
            ? response()->json([ 'status' => 'Geofence action has been added' ], 200)
            : response()->json([ 'status' => 'Geofence action could not be added' ], 500);

        return $response;
    }
}