<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $primarykey = 'id';
    protected $fillable = [''];
    protected $hidden = array('id', 'created_at', 'user');
}
