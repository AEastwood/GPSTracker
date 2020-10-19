<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;

use Illuminate\Http\Request;

class MotController extends Controller
{

    public function index() {

        $mot_stations = DB::table('mot_stations')->take(100)->get();

        return view('mot', ['mot_stations' => $mot_stations]);
    }

}
