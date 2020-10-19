<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Str;

class AssetController extends Controller
{

    /**
     * Returns summary view of particular asset
     *
     * @param  [object] request
     * @return [string] status
     */
    public function DeleteAsset(Request $request) {
        $request->validate([
            'uid' => 'required|string'
        ]);

        if(Asset::where('uid', $request->uid)->where('owner', Auth::user()->id)->delete()){
            return response()->json([
                'status' => 'Asset deleted successfully'
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'Asset failed to delete'
            ], 500);
        }
    }

    /**
     * Returns summary view of particular asset
     *
     * @param  [string] uid
     * @return [view] layouts > assets > asset
     * @return [json] Asset object
     */
    public function index_asset($uid) {
        $asset = Asset::where('uid', $uid)
            ->where('owner', Auth::user()->id)
            ->firstOrFail();

        return view('layouts.assets.asset', ['asset' => $asset]);
    }

    /**
     * Returns summary view of all of the users assets
     *
     * @return [view] layouts > assets > summary
     * @return [json] Asset object
     */
    public function index_summary() {
        $assets = Asset::where('owner', Auth::user()->id)->get();

        return view('layouts.assets.summary', ['assets' => $assets]);
    }

    /**
     * Loads view for new assets
     *
     * @return [view] layouts > assets > new
     */
    public function index_new() {
        return view('layouts.assets.new');
    }

    /**
     * Gets all users devices
     * Test function until devices implemented
     *
     * @return [json] Devices object
     */
    public static function ListMyDevices() {
        return Asset::All();
    }

    /**
     * Gets all users assets
     *
     * @return [json] Asset object
     */
    public function LoadAllUserAssets()
    {
        $myAssets = Asset::where('owner', Auth::user()->id)
            ->where('disabled', 0)
            ->where('lat', '!=', null)
            ->where('lon', '!=', null)
            ->get();

        return $myAssets;
    }

    /**
     * Adds asset in database
     *
     * @param  [object] request
     * @return [string] id
     */
    public function NewAsset(Request $request) {
        
        SubscriptionController::LimitCheck([
            'asset'
        ]);

        $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'colour' => 'required|string',
            'registration' => 'required|string'
        ]);

        $asset = new Asset([
            'make' => $request->make,
            'model' => $request->model,
            'uid' => Str::uuid(),
            'colour' => $request->colour,
            'type' => $request->type,
            'nickname' => $request->nickname,
            'registration' => $request->registration
        ]);

        $asset->owner = Auth::user()->id;
        $asset->save();

        return response()->json([
            'id' => $asset->uid
        ], 200);
    }

    /**
     * Updates asset in database
     *
     * @return [string] status
     */
    public static function SaveAsset(Request $request) {

        $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'colour' => 'required|string',
            'registration' => 'required|string'
        ]);

        $asset = Asset::where('uid', $request->uid)->where('owner', Auth::user()->id)->firstOrFail();

        $asset->update($request->all());

        return response()->json([
            'status' => 'Asset updated successfully'
        ], 200);
    }

    /**
     * Updates location of asset (Temporary test function)
     *
     * @param  [string] uid
     * @param  [string] lat : latitude
     * @param  [string] lon : Longitude
     * @return [int] status
     * @return [string] message
     */
    public function UpdateAssetLocationTEST($id, $lat, $lon)
    {
        $timestamp = date('Y-m-d H:i:s');

        $asset = Asset::where('owner', Auth::id())
            ->where('id', $id)
            ->update([
                'lat' => $lat,
                'lon' => $lon,
                'updated_at' => $timestamp
        ]);

        return response()->json([
            'status' => 200, 
            'message' => 'OK'
        ], 200);

    }

}
