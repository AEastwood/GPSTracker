<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionTypes extends Model
{
    protected $table = 'subscriptions_types';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'cost', 'title', 'max_assets', 'max_device', 'max_geofence', 'max_geofence_actions', 'enabled', 'created_at'];
    protected $hidden = array('updated_at');
}
