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
use App\Role;
use App\StaticPages;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaticPagesController extends Controller
{
    public function all()
    {
        $news = StaticPages::where('status',1)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'pages' => $news
        ], 200);
    }

    public function insert(Request $request)
    {
        $answer = new StaticPages();
        $answer->title = $request['title'];
        $answer->description = $request['description'];
        $answer->content = $request['content'];
        $answer->role_id = $request['roleId'];
        $answer->status = 1;

        if ( $answer->save() ){
            $message = 'Запись была добавлена в базу данных!';
            return response()->json([
                'message' => $message
            ], 200);
        }else{
            $message = 'Запись не была добавлена в базу данных!';
            return response()->json([
                'message' => $message
            ], 500);
        }
    }

    public function show($id)
    {
        $answer =  StaticPages::where('id',$id)->get();

        if ( $answer ){
            return response()->json([
                'page' => $answer->first()
            ], 200);
        }else{
            return response()->json([
                'message' => 'Запись не была обновлена!'
            ], 500);
        }

    }

    public function update(Request $request)
    {
        $id = $request['id'];
        $title = $request['title'];
        $description = $request['description'];
        $content = $request['content'];
        $roleId = $request['roleId'];

        $answer =  StaticPages::where('id',$id)->first();
        $answer->title = $title;
        $answer->description = $description;
        $answer->content = $content;
        $answer->role_id = $roleId;

        if ( $answer->save() ){
            $message = 'Запись была обновлена!';
        }else{
            $message = 'Запись не была обновлена!';
        }
        return response()->json([
            'message' => $message
        ], 200);
    }

    public function delete($id)
    {
        $answer =  StaticPages::where('id',$id)->first();
        $answer->status = 0;

        if ( $answer->save() ){
            $message = 'Запись была удалена из базы данных!';
        }else{
            $message = 'Запись не была удалена из базы данных!';
        }

        return response()->json([
            'message' => $message
        ], 200);
    }


}