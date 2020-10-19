<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Exceptions\AccountLimitException;
use Response;
use App\Asset;
use App\Geofence;
use App\GeofenceAction;
use App\Subscription;
use App\SubscriptionTypes;

class SubscriptionController extends Controller
{

    /**
     * validates limits against subscription limits
     * must validate to array provided or AccountLimitException is thrown
     * @param [array] params
     */
    public static function LimitCheck($params){
        $failures = [];
        $accountLimits = self::GetSubscription();

        foreach($params as $param){
            
            if($accountLimits->max_assets === -1) {
                continue;
            }

            switch($param){
                
                case 'asset':
                    if(self::AssetCount() >= $accountLimits->max_assets) array_push($failures, $param);
                    break;
                
                case 'device':
                    if(self::DeviceCount() >= $accountLimits->max_device) array_push($failures, $param);
                    break;

                case 'geofence':
                    if(self::GeofenceCount() >= $accountLimits->max_geofence) array_push($failures, $param);
                    break;
                    
                case 'geofenceaction':
                    if(self::GeofenceActionCount() >= $accountLimits->max_geofence_actions) array_push($failures, $param);
                    break;

            }
        }

        $message  = implode(", ", $failures);
        
        if(count($failures) > 0){
            throw new AccountLimitException("$message has exceeded subscription limit");
        }
    }

    /**
     * gets count of users assets
     * @return [integer] Asset Count
     */
    public static function AssetCount() {
        $assetCount = Asset::where('owner', Auth::user()->id)->count();
        return $assetCount;
    }

    /**
     * gets count of users devices
     * @return [integer] Device Count
     */
    public static function DeviceCount() {
        return Device::where('ownerId', Auth::user()->id)->count();
    }

    /**
     * gets count of geofences
     * @return [integer] Geofence Count
     */
    public static function GeofenceCount() {
        return Geofence::where('ownerId', Auth::user()->id)->count();
    }
    /**
     * gets count of geofence actions
     * @return [integer] Gefence Action Count
     */
    public static function GeofenceActionCount() {
        return GeofenceAction::where('ownerId', Auth::user()->id)->count();
    }

    /**
     * gets user subscription
     * @return [object] subscription
     */
    public static function GetSubscription() {
        $subscription = Subscription::where('userId', Auth::user()->id)
            ->rightJoin('subscriptions_types', 'subscriptions.subscriptionId', '=', 'subscriptions_types.id')
            ->firstOrFail();

        return $subscription;
    }

}
