@extends('layouts.app')

@section('map')
<div class="wrapper container-fluid">
    @auth
    <div class="row">

        <div id="leftHandContainer" class="col-lg-2 leftHandContainer scrollbar-container">
            <div class="pt-4"></div>

            {{-- CONTROLS --}}

            @component('components.map.lefthandcontrols.geofence')
            @endcomponent

            @component('components.map.lefthandcontrols.history')
            @endcomponent

            @component('components.map.lefthandcontrols.monitoring')
            @endcomponent

            @component('components.map.lefthandcontrols.asset')
            @endcomponent
            {{-- /CONTROLS --}}

            {{-- MODALS --}}
            @component('components.map.modals.settings')
            @endcomponent

            @component('components.map.modals.geofence_actions')
            @endcomponent
            {{-- /MODALS --}}

    </div>

    <div id="map" class="map col-lg-10"></div>

  </div>
    @endauth
</div>
@endsection