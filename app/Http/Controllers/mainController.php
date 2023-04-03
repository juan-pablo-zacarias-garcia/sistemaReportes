<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class mainController extends Controller
{
    public function home(Request $request)
    {
        return view('home');
    }
    public function error(Request $request)
    {
            return view('error');
    }
}

