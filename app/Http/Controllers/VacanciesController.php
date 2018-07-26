<?php

namespace App\Http\Controllers;

use App\Vacancies;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{
  // all vacancies used by status["1-active, 2-disabled"]
  public function allForGuests()
  {
    $vacancies = Vacancies::where('status',1)->orderBy('created_at', 'desc')->get();

    return response()->json([
      'vacancies' => $vacancies
    ], 200);
  }
  // all vacancies used by status["1-active, 2-disabled"]
  public function all($status)
  {
    $vacancies = Vacancies::where('status',$status)->orderBy('created_at', 'desc')->get();

    return response()->json([
      'vacancies' => $vacancies
    ], 200);
  }
  // all deleted vacancies
  public function allTrashed()
  {
    $vacancies = Vacancies::onlyTrashed()->get();

    return response()->json([
      'vacancies' => $vacancies
    ], 200);
  }
  // inserting vacancies to table:"vacancies"
  public function insert(Request $request)
  {
    $vacancy = new Vacancies();
    $vacancy->title_ru = $request['title_ru'];
    $vacancy->title_kk = $request['title_kk'];
    $vacancy->description_ru = $request['description_ru'];
    $vacancy->description_kk = $request['description_kk'];
    $vacancy->content_ru = $request['content_ru'];
    $vacancy->content_kk = $request['content_kk'];
    $vacancy->status = 1;

    if ( $vacancy->save() ){
      $message = 'Вакансия была добавлена в базу данных!';
      return response()->json([
        'message' => $message
      ], 200);
    }else{
      $message = 'Вакансия не была добавлена в базу данных!';
      return response()->json([
        'message' => $message
      ], 500);
    }
  }
  public function update(Request $request, $id)
  {
    $vacancy = Vacancies::withTrashed()->where('id',$id)->first();

    if ($vacancy)
    {
      $vacancy->title_ru = $request['title_ru'];
      $vacancy->title_kk = $request['title_kk'];
      $vacancy->description_ru = $request['description_ru'];
      $vacancy->description_kk = $request['description_kk'];
      $vacancy->content_ru = $request['content_ru'];
      $vacancy->content_kk = $request['content_kk'];
      $vacancy->status = 1;

      if ($vacancy->save())
      {
        return response()->json([
          'message' => 'Вакансия успешно была изменена'
        ],200);
      } else
      {
        return response()->json([
          'message' => 'Вакансия небыла изменена'
        ], 500);
      }
    } else // if $vacancy was not found
    {
      return response()->json([
        'message' => 'В базе небыло найдена эта вакансия, посмотрите в разделе Удаленные'
      ], 500);
    }
  }
  // get exactly one vacancy even trashed one.
  public function show($id)
  {
    $vacancy = Vacancies::withTrashed()->where('id',$id)->first();

    if ($vacancy)
    {
      return response()->json([
        'vacancy' => $vacancy
      ],200);
    } else
    {
      return response()->json([
        'message' => 'Не удалось найти вакасию'
      ],500);
    }
  }
  // get exactly one vacancy even trashed one.
  public function delete($id)
  {
    $vacancy = Vacancies::where('id',$id)->delete();

    if ($vacancy)
    {
      return response()->json([
        'message' => 'Успешно удалена'
      ],200);
    } else
    {
      return response()->json([
        'message' => 'Не удалось найти вакасию'
      ],500);
    }
  }
  // get exactly one vacancy even trashed one.
  public function disable($id)
  {
    $vacancy = Vacancies::where('id',$id)->first();

    if ($vacancy)
    {
      $vacancy->status = 2;
      if ($vacancy->save())
      {
        return response()->json([
          'message' => 'Успешно отключена'
        ],200);
      }else
      {
        return response()->json([
          'message' => 'Не удалось отключить вакансию'
        ],500);
      }
    } else
    {
      return response()->json([
        'message' => 'Не удалось найти вакасию'
      ],500);
    }
  }
  // get exactly one vacancy even trashed one.
  public function unDisable($id)
  {
    $vacancy = Vacancies::where('id',$id)->first();

    if ($vacancy)
    {
      $vacancy->status = 1;
      if ($vacancy->save())
      {
        return response()->json([
          'message' => 'Успешно включена'
        ],200);
      }else
      {
        return response()->json([
          'message' => 'Не удалось включить вакансию'
        ],500);
      }
    } else
    {
      return response()->json([
        'message' => 'Не удалось найти вакасию'
      ],500);
    }
  }
  // get exactly one vacancy even trashed one.
  public function recovery($id)
  {
    $vacancy = Vacancies::withTrashed()->where('id',$id)->first();

    if ($vacancy)
    {
      $vacancy->deleted_at = null;
      if ($vacancy->save())
      {
        return response()->json([
          'message' => 'Успешно востановлена'
        ],200);
      }else
      {
        return response()->json([
          'message' => 'Не удалось востановить'
        ],500);
      }
    } else
    {
      return response()->json([
        'message' => 'Не удалось найти вакасию'
      ],500);
    }
  }

}