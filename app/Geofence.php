<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geofence extends Model
{
    protected $table = 'geofence_data';
    protected $primarykey = 'id';
    protected $fillable = ['uid', 'name', 'colour', 'data', 'disabled', 'ownerId'];
    protected $hidden = array('id', 'ownerId');
}
