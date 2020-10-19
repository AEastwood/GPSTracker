<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetTypes extends Model
{
    
    protected $table = 'asset_types';
    protected $primarykey = 'id';

    protected $fillable = [
        'type'
    ];
}
