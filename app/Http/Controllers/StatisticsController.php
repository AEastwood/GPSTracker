<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{

    public function index() {
        return view('statistics');
    }

}
