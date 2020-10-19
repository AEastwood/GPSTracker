<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index() {
        return view('invoices');
    }

}
