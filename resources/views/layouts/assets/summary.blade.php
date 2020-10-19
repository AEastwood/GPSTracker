<?php
use App\Http\Controllers\SubscriptionController;

$sc = new SubscriptionController;
$subscription = $sc->GetSubscription();

$assetUsed = $sc->AssetCount();
$assetLimit = $sc->GetSubscription()->max_assets;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name') }} :: Assets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="These buttons examples contain icons with or without labels attached.">

    <meta name="msapplication-tap-highlight" content="no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
    <link href="{{ asset('css/architect.css') }}" rel="stylesheet">
    @auth
    <link href="{{ asset('css/assets.css') }}?{{rand(0, getrandmax()) }}" rel="stylesheet">
    @endauth
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
                        My Assets
                        <div class="page-title-subheading">Manage all of your assets here. Simply click an asset in order to modify it.</div>
                        <div class="page-title-subheading">Assets: {{ $assetUsed }} /@if($assetLimit === -1) Unlimited @else {{ $assetLimit }} @endif</div>
                    </div>
                </div>
    
                <div class="page-title-actions">
                    <button class="btn-icon btn btn-secondary" onclick="window.location.href='/home'"><i class="fas fa-home"></i></button>
                    @if($assetUsed >= $assetLimit)
                        @if($assetLimit === -1)
                        <button class="btn-icon btn btn-success" onclick="window.location.href='/assets/new'"><i class="fas fa-plus btn-icon-wrapper"> </i>Add Asset</button>
                        @else
                        <button class="btn-icon btn btn-warning" onclick="window.location.href='/subscription'"><i class="fas fa-chevron-circle-up"></i> </i>Upgrade</button>
                        @endif
                    @else
                    <button class="btn-icon btn btn-success" onclick="window.location.href='/assets/new'"><i class="fas fa-plus btn-icon-wrapper"> </i>Add Asset</button>
                    @endif
                </div> 
            </div>
        </div>
    
        <div class="main-card mb-3 card">
            <div class="card-body">
                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Registration</th>
                        <th>Colour</th>
                        <th>Type</th>
                    </tr>
                    </thead>
                    <tbody>
    
                    @foreach($assets as $asset)
                    <tr onclick="window.location.href='/assets/{{ ucwords($asset->uid) }}'" style="cursor:pointer;">
                        <td>{{ $asset->make }}</td>
                        <td>{{ $asset->model }}</td>
                        <td>{{ $asset->registration }}</td>
                        <td>{{ $asset->colour }}</td>
                        <td>{{ ucwords($asset->type) }}</td>
                    </tr>
                    @endforeach
    
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Registration</th>
                        <th>Colour</th>
                        <th>Type</th>
                    </tr>
                    </tfoot>
                </table>
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
