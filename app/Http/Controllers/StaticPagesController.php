<?php

namespace App\Http\Controllers;


use App\StaticPages;
use Illuminate\Http\Request;


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
    $answer->title_ru = $request['title_ru'];
    $answer->title_kk = $request['title_kk'];
    $answer->description_ru = $request['description_ru'];
    $answer->description_kk = $request['description_kk'];
    $answer->content = $request['content'];
    $answer->content_kk = $request['content_kk'];
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
    $answer =  StaticPages::where('id',$id)
        ->where('status',1)
        ->first();

    if ( $answer ){
        return response()->json([
            'page' => $answer
        ], 200);
    }else{
        return response()->json([
            'message' => 'Запись не была найдена!'
        ], 500);
    }

  }

  public function update(Request $request)
  {
    $id = $request['id'];

    $answer =  StaticPages::where('id',$id)->first();
    $answer->title_ru = $request['title_ru'];
    $answer->title_kk = $request['title_kk'];
    $answer->description_ru = $request['description_ru'];
    $answer->description_kk = $request['description_kk'];
    $answer->content = $request['content'];
    $answer->content_kk = $request['content_kk'];

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