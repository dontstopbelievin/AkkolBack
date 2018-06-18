<?php

namespace App\Http\Controllers;

use App\News;
use App\StaticPages;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    public function search()
    {
        $query = Input::get('query');

        $services = collect([
            ['title' => 'Выдача АПЗ', 'description' => 'Выдача архитектурно-планировочного задания', 'created_at' => date('Y-m-d H:i:s')],
        ])->filter(function ($value, $key) use ($query) {
            return strpos(mb_strtolower($value['title']), mb_strtolower($query)) !== false || strpos(mb_strtolower($value['description']), mb_strtolower($query)) !== false;
        });

        $news = News::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->orWhere('text', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        $pages = StaticPages::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        $result = $services->merge($news, $pages);

        return response()->json(['result' =>  $result->sortByDesc('created_at')], 200);
    }
}
