<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetEmailController extends Controller
{
    //
    public function getEmail($email,$token){
        $answer = DB::table('password_resets')->where('email', $email)->first();
        $condition = \Hash::check($token,$answer->token);
        if ($condition){
            return response()->json(['email' => $answer->email ], 200);
        }else{
            return response()->json(['error' => 'fail'], 500);
        }
    }
}
