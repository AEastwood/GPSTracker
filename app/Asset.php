<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'vehicles';
    protected $primarykey = 'id';
    protected $fillable = ['make', 'model', 'colour', 'nickname', 'type', 'uid', 'registration'];
    protected $hidden = array('id', 'created_at', 'owner');
}
