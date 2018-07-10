<?php

namespace App\Http\Controllers;

use App\Questions;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    //вопрос админу
    public function insert(Request $request, $id)
    {
        $question = new Questions();
        $question->question = $request['question'];
        $question->status = 1;
        $question->user_id = $id;

        if ($question->save()) {
            return response()->json([
                'answer' => 'Вопрос успешно отправлен администрацию. Ожидайте ответа!'
            ], 200);
        } else {
            return response()->json([
                'answer' => 'Ошибка во время отправления вопроса !'
            ], 500);
        }
    }
    //вопрос админу без зарегистрированного пользователя
    public function insertWithoutUser (Request $request)
    {
        $question = new Questions();
        $question->question = $request['question'];
        $question->status = 1;

        if ($question->save()) {
            return response()->json([
                'answer' => 'Вопрос успешно отправлен администрацию. Ожидайте ответа!'
            ], 200);
        } else {
            return response()->json([
                'answer' => 'Ошибка во время отправления вопроса !'
            ], 500);
        }
    }
    //ответ от админа
    public function update(Request $request)
    {
        $id = $request['id'];
        $answer = $request['answer'];

        $question = Questions::where('id', $id)->first();
        $question->status = 2;
        $question->answer = $answer;

        if ($question->save()) {
            return response()->json([
                'answer' => 'Ответ был отправлен пользователю!'
            ], 200);
        } else {
            return response()->json([
                'answer' => 'Ошибка во время оправления ответа!'
            ], 500);
        }
    }
    //удаление новости
    public function delete($id)
    {
        $question = Questions::where('id', $id)->delete();

        if ($question) {
            return response()->json([
                'answer' => 'Вопрос успешно удален!'
            ], 200);
        }else {
            return response()->json([
                'answer' => 'Во время удаления произошла ошибка!'
            ], 500);
        }
    }
    //вопросы для админа
    public function all()
    {
        $questions = Questions::get();

        if ($questions)
        {
            return response()->json([
                'questions' => $questions
            ], 200);
        } else {
            return response()->json([
                'answer' => 'В базе данных нет вопросов еще!'
            ], 500);
        }
    }

    //эта функция специально для одного пользователя, по айди должен придти айди пользователя
    public function allUsers ($id)
    {
        $questions = Questions::where('user_id',$id)->get();

        if ($questions)
        {
            return response()->json([
                'questions' => $questions
            ], 200);
        } else {
            return response()->json([
                'answer' => 'В базе данных нет вопросов еще!'
            ], 500);
        }
    }


}
