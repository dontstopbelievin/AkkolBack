<?php

namespace App\Http\Controllers\Apz;

use App\ApzAnswerTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApzAnswerTemplateController extends Controller
{
    /**
     * Show all templates
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $templates = ApzAnswerTemplate::where(['user_id' => \Auth::user()->id])->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($templates, 200);
    }

    /**
     * Create template
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $template = new ApzAnswerTemplate();
        $template->title = $request->title;
        $template->text = $request->text;
        $template->user_id = \Auth::user()->id;
        $template->is_active = $request->is_active;

        if (!$template->save()) {
            return response()->json(['message' => 'Не удалось создать шаблон'], 500);
        }

        return response()->json(['message' => 'Шаблон успешно создан'], 200);
    }

    /**
     * Show template
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $template = ApzAnswerTemplate::where(['id' => $id, 'user_id' => \Auth::user()->id])->first();

        if (!$template) {
            return response()->json(['message' => 'Шаблон не найден'], 404);
        }

        return response()->json($template, 200);
    }

    /**
     * Update template
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $template = ApzAnswerTemplate::where(['id' => $id, 'user_id' => \Auth::user()->id])->first();

        if (!$template) {
            return response()->json(['message' => 'Шаблон не найден'], 404);
        }

        $template->title = $request->title;
        $template->text = $request->text;
        $template->user_id = \Auth::user()->id;
        $template->is_active = $request->is_active;

        if (!$template->save()) {
            return response()->json(['message' => 'Не удалось изменить шаблон'], 500);
        }

        return response()->json(['message' => 'Шаблон успешно изменен'], 200);
    }

    /**
     * Delete template
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $template = ApzAnswerTemplate::where(['id' => $id, 'user_id' => \Auth::user()->id])->first();

        if (!$template) {
            return response()->json(['message' => 'Шаблон не найден'], 404);
        }

        if (!$template->delete()) {
            return response()->json(['message' => 'Не удалось удалить шаблон'], 500);
        }

        return response()->json(['message' => 'Шаблон успешно удален'], 200);
    }
}
