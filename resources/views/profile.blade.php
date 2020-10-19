<?php

use App\Http\Controllers\SubscriptionController;

$sc = new SubscriptionController;
$subscription = $sc->GetSubscription();

?>

@extends('layouts.profile')

@section('content')
<div class="container p-0">

    <h1 class="h3 mb-3 pt-5">Settings</h1>

    <div class="row">
        <div class="col-md-5 col-xl-4">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Settings</h5>
                </div>

                <div class="list-group list-group-flush" role="tablist">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account" role="tab">
                      Account
                    </a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#password" role="tab">
                      My API Details
                    </a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#data" role="tab">
                      My Data
                    </a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#subscription" role="tab">
                      My Subscription
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xl-8">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="account" role="tabpanel">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Account Information</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputName">Email Address</label>
                                            <input type="text" class="form-control" id="inputUsername" placeholder="{{ Auth::user()->email }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="pt-4"></div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Profile Picture</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('/profile/updateprofileimage') }}" enctype="multipart/form-data">
                                <div class="text-center">
                                    <img alt="{{ Auth::user()->name }}" src="/imgs/userprofilepics/{{ Auth::user()->display_image }}" class="rounded-circle img-responsive mt-2" width="128" height="128">
                                </div>
                                <div class="text-center pt-3">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="file" name="image">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="pt-4"></div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">My Information</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputFirstName">First name</label>
                                        <input type="text" class="form-control" id="inputFirstName" placeholder="First name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputLastName">Last name</label>
                                        <input type="text" class="form-control" id="inputLastName" placeholder="Last name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Address</label>
                                    <input type="text" class="form-control" id="inputAddress" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Address 2</label>
                                    <input type="text" class="form-control" id="inputAddress2" placeholder="">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCity">City</label>
                                        <input type="text" class="form-control" id="inputCity">
                                    </div>
                                    <!-- <div class="form-group col-md-4">
                                        <label for="inputState">State</label>
                                        <select id="inputState" class="form-control">
                                            <option selected="">Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div> -->
                                    <div class="form-group col-md-3">
                                        <label for="inputZip">Post Code</label>
                                        <input type="text" class="form-control" id="inputZip">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>

                        </div>
                    </div>
                    <div class="pt-4"></div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Update Password</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="inputPasswordNew">New password</label>
                                    <input type="password" class="form-control" id="inputPasswordNew">
                                </div>
                                <div class="form-group">
                                    <label for="inputPasswordNew2">Verify password</label>
                                    <input type="password" class="form-control" id="inputPasswordNew2">
                                    <small>A password change confirmation email will be sent to {{Auth::user()->email }}.</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>

                    <div class="pt-4"></div>
                    <div class="card ">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Delete my account</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="datadownload pb-3">If you want to permanently delete your {{ config('app.name') }} account, let us know. Once the deletion process has begun, you won't be able to reactivate your account or retrieve any of the content or information that you've added.</div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="confirmdelete">
                                    <label class="form-check-label" for="confirmdelete">
                                        I want to delete my account
                                    </label>
                                </div>
                                <div class="deletebutton pt-4">
                                    <button type="submit" class="btn btn-danger">Delete my account</button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="pt-4"></div>

                </div>
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">API Access</h5>
                        </div>
                        <div class="card-body">
                            

                            <form>
                                <div class="form-group">
                                    <label for="apiKEY">API Documentation</label>
                                    <div class="apiDocs">
                                        You can see all the documentation for our API here: <a href="/apidocs/v1" target="_blank">API Documentation</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="apiKEY">My API Key</label>
                                    <input type="text" class="form-control" id="inputPasswordNew" value="{{ Auth::user()->api_token }}" readonly>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="data" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">My Data</h5>
                        </div>
                        <div class="card-body">
                            
                            <form>
                                <div class="datadownload">
                                    You can download a copy of your {{ config('app.name') }} information at any time. You can download a complete copy, or you can select only the types of information and date ranges that you want. You can choose to receive your information in an HTML format that is easy to view, or a JSON format, which could allow another service to import it more easily.
                                </div>
                                <div class="pb-3 pt-2"> 
                                    Once your copy has been created, it will be available for download for a 7 days.
                                </div>
                                <div class="downloadbutton">
                                    <button type="submit" class="btn btn-primary">Request My Data</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="subscription" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">My Subscription</h5>
                        </div>
                        <div class="card-body">
                            
                            <table class="mb-0 table table-bordered justify-content-center">
                                <thead>
                                    <tr>
                                        <th>Plan</th>
                                        <th>Assets (Max)</th>
                                        <th>Devices (Max)</th>
                                        <th>Geofences (Max)</th>
                                        <th>Geofence Actions (Max)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $subscription->title }}</th>
                                        <td>@if($subscription->max_assets === -1) Unlimited @else {{ $subscription->max_assets }} @endif</td>
                                        <td>@if($subscription->max_device === -1) Unlimited @else {{ $subscription->max_device }} @endif</td>
                                        <td>@if($subscription->max_geofence === -1) Unlimited @else {{ $subscription->max_geofence }} @endif</td>
                                        <td>@if($subscription->max_geofence_actions === -1) Unlimited @else {{ $subscription->max_geofence_actions }} @endif</td>
                                    </tr>
                                </tbody>
                            </table>

                            @if($subscription->upgradeable)
                            <div class="pt-4">
                                <h2 class="pb-2 text-center">Pick your Subscription</h2>
                                <p class="pb-3 text-center">Need More? Click below to choose the perfect subscription plan for your needs</p>
                                <button class="btn btn-success btn-block" onclick="window.location.href='/subscription'">Upgrade My Subscription</button>
                            </div>
                            @else
                            <div class="pt-5">
                                <h2 class="pb-2 text-center">You're already Unlimited <i class="fas fa-smile-wink"></i></h2>
                                <p class="pb-3 text-center">What more could you need?</p>
                                <button class="btn btn-warning btn-block" onclick="window.location.href='/contact'">Contact Us</button>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
