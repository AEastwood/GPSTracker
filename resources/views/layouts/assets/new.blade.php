<?php

use App\Http\controllers\AssetController;
use App\AssetTypes;

$assetTypes = AssetTypes::orderBy('title', 'asc')->get();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name') }} :: New Asset</title>
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
                        New Asset
                        <div class="page-title-subheading">Add a new asset and assign a device to instantly track it</div>
                    </div>
                </div>

                <div class="page-title-actions">
                    <button class="btn-icon btn btn-danger" onclick="window.location.href='/assets'"><i class="fas fa-chevron-left"></i> Cancel</button>
                </div> 
            </div>
        </div>

        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Asset Details</h5>
                <form class="" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}">
                    @CSRF
                    
                    <div id="makeParent" class="position-relative row form-group">
                        <label for="makeTxtbox" class="col-sm-2 col-form-label">
                            Make
                        </label>
                        <div class="col-sm-10">
                            <input id="makeTxtbox" placeholder="Make" type="text" value="" class="form-control" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}">
                        </div>
                    </div>

                    <div id="" class="position-relative row form-group">
                        <label for="modelTxtbox" class="col-sm-2 col-form-label">
                            Model
                        </label>
                        <div class="col-sm-10">
                            <input id="modelTxtbox" placeholder="Model" value="" type="text" class="form-control" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}">
                        </div>
                    </div>

                    <div id="colourParent" class="position-relative row form-group">
                        <label for="colourTxtbox" class="col-sm-2 col-form-label">
                            Colour
                        </label>
                        <div class="col-sm-10">
                            <input id="colourTxtbox" placeholder="Colour" value="" type="text" class="form-control" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}">
                        </div>
                    </div>

                    <div id="nicknameParent" class="position-relative row form-group">
                        <label for="nicknameTxtbox" class="col-sm-2 col-form-label">
                            Nickname
                        </label>
                        <div class="col-sm-10">
                            <input id="nicknameTxtbox" placeholder="Nickname" value="" type="text" class="form-control" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}">
                        </div>
                    </div>

                    <div id="registrationParent" class="position-relative row form-group">
                        <label for="registrationTxtbox" class="col-sm-2 col-form-label">
                            Registration
                        </label>
                        <div class="col-sm-10">
                            <input id="registrationTxtbox" placeholder="Registration" value="" type="text" class="form-control" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}">
                        </div>
                    </div>

                    <div id="typeParent" class="position-relative row form-group">
                        <label for="assetTypeSelect" class="col-sm-2 col-form-label">
                            Type
                        </label>
                        <div class="col-sm-10">
                            <select name="select" id="assetTypeSelect" class="form-control" name="{{ rand(0, getrandmax()) }}" autocomplete="{{ rand(0, getrandmax()) }}">
                                @foreach($assetTypes as $type)
                                <option value="{{ ucwords($type->title) }}">{{ ucwords($type->title) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-check">
                        <button id="saveAsset" onclick="AddNewAsset();" class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
    </div>
        </main>
    </div>
    <div class="app-drawer-overlay d-none animated fadeIn "></div>
    <script type="text/javascript " src="{{ asset( 'js/home.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
