@extends('layouts.mot')

@section('mymotcentre')

<div class="container" style="padding-top: 55px;">
    <div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="lnr-car icon-gradient bg-dark"></i>
            </div>
            <div>
                Calendar
                <div class="page-title-subheading">Manage all of your tasks here. You can Add, Ammend or Delete them.</div>
            </div>
        </div>
       </div>
    </div>

    <!-- <h1 class="h3 mb-4 pt-5">My MOT Centre</h1>  -->

      <div class='demos__container calendar-background '>
          <div class="test"> </div>
        <div class='demos__sidebar' style="display:none;">
          <div class='accordion' id='demo-accordion'></div>
        </div>
        <div class='demos__main '>
          <div class='demos__main-container ' id='calendar'>
          </div>
        </div>
      </div>
</div>

{{-- <table id="mot_stations" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">Trading Name</th>
            <th class="th-sm">Site Number</th>
            <th class="th-sm">Address 1</th>
            <th class="th-sm">Address 2</th>
            <th class="th-sm">Address 3</th>
            <th class="th-sm">Address 4</th>
            <th class="th-sm">Postcode</th>
            <th class="th-sm">Telephone</th>
            <th class="th-sm">Class 1</th>
            <th class="th-sm">Class 2</th>
            <th class="th-sm">Class 3</th>
            <th class="th-sm">Class 4</th>
            <th class="th-sm">Class 5</th>
            <th class="th-sm">Class 7</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mot_stations as $mot_station)
        <tr>
            <td>{{ $mot_station->trading_name }}</td>
            <td>{{ $mot_station->site_number }}</td>
            <td>{{ $mot_station->address_1 }}</td>
            <td>{{ $mot_station->address_2 }}</td>
            <td>{{ $mot_station->address_3 }}</td>
            <td>{{ $mot_station->address_4 }}</td>
            <td>{{ $mot_station->post_code }}</td>
            <td>{{ str_replace('_', '', $mot_station->telephone) }}</td>
            <td>{{ $mot_station->class_1 }}</td>
            <td>{{ $mot_station->class_2 }}</td>
            <td>{{ $mot_station->class_3 }}</td>
            <td>{{ $mot_station->class_4 }}</td>
            <td>{{ $mot_station->class_5 }}</td>
            <td>{{ $mot_station->class_7 }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="th-sm">Trading Name</th>
            <th class="th-sm">Site Number</th>
            <th class="th-sm">Address 1</th>
            <th class="th-sm">Address 2</th>
            <th class="th-sm">Address 3</th>
            <th class="th-sm">Address 4</th>
            <th class="th-sm">Postcode</th>
            <th class="th-sm">Telephone</th>
            <th class="th-sm">Class 1</th>
            <th class="th-sm">Class 2</th>
            <th class="th-sm">Class 3</th>
            <th class="th-sm">Class 4</th>
            <th class="th-sm">Class 5</th>
            <th class="th-sm">Class 7</th>
        </tr>
    </tfoot>
</table> --}}
</div>
@endsection

@section('bookanmot')
<div class="container p-0 mb-3">
<h1 class="h3 mb-4 pt-5">Book an MOT</h1>
    No MOTs available
</div>
@endsection
