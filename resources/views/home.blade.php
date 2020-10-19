@extends('layouts.home')

@section('content')
<div class="homeGrid">

    <div class="row">
        <div class="col text-center displaypic noselect">
            <img src="/imgs/userprofilepics/{{ Auth::user()->display_image }}" width="150" height="150" class="rounded-circle img-responsive">
        </div>
    </div>

    <div class="row pt-5 pb-5">
        <div class="col h2 text-center noselect">
            Welcome, {{ ucwords(Auth::user()->name) }}
        </div>
    </div>

    <div class="row pt-3 noselect">

        <div class="col text-center homeButton">
            <a href="/map">
                <img src="{{ asset('/imgs/ico/homeico/map.png') }}" class="pb-3">
                <p>Map</p>
            </a>
        </div>


        <div class="col text-center homeButton">
            <a href="/mot">
                <img src="{{ asset('/imgs/ico/homeico/mot.png') }}" class="pb-3">
                <p>Book an MOT</p>
            </a>
        </div>

        <div class="col text-center homeButton">
            <a href="/assets">
                <img src="{{ asset('/imgs/ico/homeico/car.png') }}" class="pb-3">
                <p>My Assets</p>
            </a>
        </div>

        <div class="col text-center homeButton">
            <a href="/assets">
                <img src="{{ asset('/imgs/ico/homeico/car.png') }}" class="pb-3">
                <p>My Devices</p>
            </a>
        </div>

        <div class="col text-center homeButton">
            <a href="/statistics">
                <img src="{{ asset('/imgs/ico/homeico/report.png') }}" class="pb-3">
                <p>My Statistics</p>
            </a>
        </div>

        <div class="col text-center homeButton">
            <a href="/invoices">
                <img src="{{ asset('/imgs/ico/homeico/receipt.png') }}" class="pb-3">
                <p>My Billing</p>
            </a>
        </div>

    </div>

</div>
@endsection
