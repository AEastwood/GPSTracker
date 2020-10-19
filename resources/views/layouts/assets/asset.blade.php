<?php

use app\Http\controllers\AssetController;
use App\AssetTypes;

$myDevices = AssetController::ListMyDevices();
$assetTypes = AssetTypes::orderBy('title', 'asc')->get();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name') }} :: {{ $asset->make }}  {{ $asset->model }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="These buttons examples contain icons with or without labels attached.">

    <meta name="msapplication-tap-highlight" content="no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
    <script src="{{ asset('js/assets.js') }}?{{ rand(0, getrandmax()) }}"></script>    
    <link href="{{ asset('css/architect.css') }}" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        @component('components.navbar')
        @endcomponent
        <main class="" style="padding-top: 55px;">
        <div class="container" style="padding-top: 55px;">
		
        <div class="app-page-title">
            <div class="page-title-wrapper">
                
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="lnr-car icon-gradient bg-dark">
                        </i>
                    </div>
                    <div>
                        @if(isset($asset->nickname))
                        {{ $asset->nickname }} ({{ $asset->registration }})
                        @else
                        {{ $asset->make }} {{ $asset->model }} 
                            @if(isset($asset->registration))
                            ({{ $asset->registration }})
                            @endif
                        @endif
                        <div class="page-title-subheading">Asset ID: {{ $asset->uid }}</div>
                    </div>
                </div>

                <div class="page-title-actions">
                    <button class="btn-icon btn btn-secondary" onclick="window.location.href='/home'"><i class="fas fa-home"></i></button>
                    <button class="btn-icon btn btn-primary" onclick="window.history.back();"><i class="fas fa-chevron-left"></i> Go Back</button>
                </div> 
            </div>
        </div>

        <div class="main-card mb-3 card">
            <div class="card-body">

                @if(!isset($asset->lat) || !isset($asset->lon))
                <div class="alert alert-warning fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> 
                    This asset has no location data and will not be visible on the map
                </div>
                @endif

                <h5 class="card-title">Asset Details</h5>
                <form class="">
                    <div class="position-relative row form-group"><label for="makeTxtbox" class="col-sm-2 col-form-label">Make</label>
                        <div class="col-sm-10"><input class="form-control" id="makeTxtbox" placeholder="Make" type="text"  name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}" value="{{ $asset->make }}"></div>
                    </div>

                    <div class="position-relative row form-group"><label for="modelTxtbox" class="col-sm-2 col-form-label">Model</label>
                        <div class="col-sm-10"><input class="form-control" id="modelTxtbox" placeholder="Model"  name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}" value="{{ $asset->model }}" type="text"></div>
                    </div>

                    <div class="position-relative row form-group"><label for="colourTxtbox" class="col-sm-2 col-form-label">Colour</label>
                        <div class="col-sm-10"><input class="form-control" id="colourTxtbox" placeholder="Model"  name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}" value="{{ $asset->colour }}" type="text"></div>
                    </div>

                    <div class="position-relative row form-group"><label for="nicknameTxtbox" class="col-sm-2 col-form-label">Nickname</label>
                        <div class="col-sm-10"><input class="form-control" id="nicknameTxtbox" placeholder="Nickname" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}" value="{{ $asset->nickname }}" type="text"></div>
                    </div>

                    <div class="position-relative row form-group"><label for="RegistrationTxtbox" class="col-sm-2 col-form-label">Registration</label>
                        <div class="col-sm-10"><input class="form-control" id="registrationTxtbox" placeholder="Registration No." name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}" value="{{ $asset->registration }}" type="text"></div>
                    </div>

                    <div class="position-relative row form-group"><label for="assetTypeSelect" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-10">
                            <select name="select" id="assetTypeSelect" value="{{ $asset->title }}" class="form-control" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}">
                                @foreach($assetTypes as $type)
                                <option value="{{ $type->title }}"
                                    @if($asset->type === $type->title) selected @endif >
                                    {{ ucwords($type->title) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Associated Tracker</label>
                        <div class="col-sm-10">
                            <select id="exampleSelect" class="form-control">
                                @foreach($myDevices as $device)
                                <option value="{{ $device->uid }}">{{ $device->make }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-check">
                        <button class="btn btn-success" onclick="SaveAsset('{{ $asset->uid }}');">Save</button>
                        <button class="btn btn-danger" onclick="DeleteAsset('{{ $asset->uid }}');">Delete Asset</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </div>
        </main>
    </div>
    <div class="app-drawer-overlay d-none animated fadeIn "></div>
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
