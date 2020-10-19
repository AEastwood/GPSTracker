<?php

use Illuminate\Http\Request;
use App\GeofenceData;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});