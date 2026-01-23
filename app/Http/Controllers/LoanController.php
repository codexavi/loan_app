<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $loanDetails = DB::table('loan_details')->get();
        return view('loan_details', compact('loanDetails'));
    }
}
