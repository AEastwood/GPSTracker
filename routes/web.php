<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

########################## APP FRONTEND ########################
Route::middleware('auth:web')->get('/map', 'MapController@index')->name('map');
Route::middleware('auth:web')->get('/home', 'HomeController@index')->name('home');
Route::middleware('auth:web')->get('/invoices', 'InvoiceController@index')->name('invoice');
//Route::middleware('auth:web')->get('/mot', 'MotController@index')->name('mot');
Route::middleware('auth:web')->get('/profile', 'ProfileController@index')->name('profile');
Route::middleware('auth:web')->get('/statistics', 'StatisticsController@index')->name('statistics');

########################## ASSETS ############################

Route::group(['prefix' => '/assets'], function() {
    Route::middleware('auth:web')->get('', 'AssetController@index_summary');
    Route::middleware('auth:web')->post('add', 'AssetController@NewAsset');
    Route::middleware('auth:web')->post('delete', 'AssetController@DeleteAsset');
    Route::middleware('auth:web')->get('loadall', 'AssetController@LoadAllUserAssets');
    Route::middleware('auth:web')->get('new', 'AssetController@index_new');
    Route::middleware('auth:web')->post('save', 'AssetController@SaveAsset');
    Route::middleware('auth:web')->get('{id}', 'AssetController@index_asset');
});


########################## GEOFENCE ##########################
Route::group(['prefix' => 'geofence'], function () {
    Route::middleware('auth:web')->get('/loadall', 'GeofenceController@AllGeofences');
    Route::middleware('auth:web')->post('/save', 'GeofenceController@SaveGeofence');
    Route::middleware('auth:web')->post('/delete', 'GeofenceController@DeleteGeofence');
});

########################## GEOFENCE ACTIONS ##########################
Route::group(['prefix' => 'geofenceaction'], function () {
    Route::middleware('auth:web')->get('/loadall', 'GeofenceController@AllGeofenceActions');
    Route::middleware('auth:web')->post('/save', 'GeofenceController@SaveGeofenceAction');
    Route::middleware('auth:web')->post('/delete', 'GeofenceController@DeleteGeofenceAction');
});


########################## PROFILE ##########################
Route::group(['prefix' => 'profile'], function (){
    Route::middleware('auth:web')->post('/updateprofileimage', 'ProfileController@ChangeProfileImage');
    Route::middleware('auth:web')->get('/updatedangerzone/{dangerzone}', 'ProfileController@UpdateDangerzone');
    Route::middleware('auth:web')->get('/updatetheme/{theme}', 'ProfileController@UpdateTheme');
    Route::middleware('auth:web')->get('/updatemapmode/{map_mode}', 'ProfileController@UpdateMapMode');
    Route::middleware('auth:web')->get('/updaterefresh/{refresh}', 'ProfileController@UpdateRefresh');
});