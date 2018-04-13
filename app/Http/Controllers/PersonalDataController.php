<?php

namespace App\Http\Controllers;

use App\Apz;
use App\ApzState;
use App\ApzStateHistory;
use App\ApzStatus;
use App\Commission;
use App\CommissionUser;
use App\Http\Controllers\Controller;
use App\News;
use App\PersonalData;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonalDataController extends Controller
{



    public function update(Request $request, $id)
    {



        $answer =  PersonalData::where('id',$id)->first();
        $answer->first_name = $request['first_name'];
        $answer->last_name = $request['last_name'];
        $answer->middle_name = $request['middle_name'];
        $answer->email = $request['email'];
        $answer->company_name = $request['company_name'];
        $answer->company_name = $request['company_name'];

        if ($request['bin'] != ''){
            $answer->bin = $request['bin'];
        }
        else{
            $answer->iin = $request['iin'];
        }

        if ( $answer->save() ){
            $message = 'Запись была обновлена!';
        }else{
            $message = 'Запись не была обновлена!';
        }

        return response()->json([
            'message' => $message
        ], 200);
    }
    public function edit($id)
    {

        $answer =  PersonalData::where('id',$id)->get();

        if ( $answer ){
            return response()->json([
                'userData' => $answer->first()
            ], 200);
        }else{
            $message = 'Запись не была найдена!';
            return response()->json([
                'message' => $message
            ], 500);
        }

    }



}
