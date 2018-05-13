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
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Show news list for region
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {


        $news = News::where('status',1)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'news' => $news
        ], 200);
    }

    public function insert(Request $request)
    {
        $answer = new News();
        $answer->title = $request['title'];
        $answer->description = $request['description'];
        $answer->heading_id = $request['heading_id'];
        $answer->text = $request['text'];


        if ( $answer->save() ){
            $message = 'Запись была добавлена в базу данных!';
        }else{
            $message = 'Запись не была добавлена в базу данных!';
        }

        return response()->json([
            'message' => $message
        ], 200);
    }


    public function update(Request $request)
    {

        $id = $request['id'];
        $title = $request['title'];
        $description = $request['description'];
        $text = $request['text'];
        $heading_id = $request['heading_id'];
//        $answer = News::where('id',$id)
//                        ->update(['title' => $title, 'description' => $description, 'text' => $text ]);

        $answer =  News::where('id',$id)->first();
        $answer->title = $title;
        $answer->description = $description;
        $answer->text = $text;
        $answer->heading_id = $heading_id;

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

//        $answer = News::where('id',$id)
//                        ->update(['title' => $title, 'description' => $description, 'text' => $text ]);

        $answer =  News::where('id',$id)->get();

        if ( $answer ){
            return response()->json([
                'article' => $answer->first()
            ], 200);
        }else{
            $message = 'Запись не была обновлена!';
            return response()->json([
                'message' => $message
            ], 200);
        }

    }

    public function delete($id)
    {

        $answer =  News::where('id',$id)->first();
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

    public function lastFresh () {
        $news = News::where('status',1)->
                        orderBy('created_at', 'desc')->
                        limit(4)->
                        get();

        if($news){
            return response()->json([
                'news' => $news
            ], 200);
        }else{
            return response()->json([
                'error' => 'fail'
            ], 500);
        }
    }

    public function allNews() {
        $news = News::where('status',1)->
                        orderBy('created_at', 'desc')->
                        get();

        if($news){
            return response()->json([
                'news' => $news
            ], 200);
        }else{
            return response()->json([
                'error' => 'fail'
            ], 500);
        }
    }

    public function article($id) {
        $answer =  News::where('id',$id)->
                            first();

        if ( $answer ){
            return response()->json([
                'article' => $answer
            ], 200);
        }else{
            return response()->json([
                'error' => 'fail'
            ], 500);
        }

    }

    public function dayNews($day) {
        $answer =  News::whereDate('created_at', $day )
                            ->where('status',1)->get();

        if ( $answer != null ){
            return response()->json([
                'news' => $answer
            ], 200);
        }else{
            return response()->json([
                'error' => 'fail'
            ], 500);
        }
    }


}
