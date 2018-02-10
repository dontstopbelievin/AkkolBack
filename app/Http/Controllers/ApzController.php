<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApzController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['test' => 'test'], 200);
    }
}
