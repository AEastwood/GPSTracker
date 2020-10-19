<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeofenceAction extends Model
{
    protected $table = 'geofence_actions';
    protected $primarykey = 'id';

    protected $fillable = [
        'uid',
        'data',
        'disabled',
        'geofence_uid',
        'name',
        'ownerId'
    ];

    protected $hidden = array('id', 'ownerId');
}
