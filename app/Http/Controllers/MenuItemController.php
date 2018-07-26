<?php

namespace App\Http\Controllers;

use App\MenuCategory;
use App\MenuItem;
use App\Role;
use App\StaticPages;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function all()
    {
        $item = MenuItem::orderBy('created_at', 'desc')->get();

        return response()->json([
            'menu_item' => $item
        ], 200);
    }

    public function getCategories () {
        $item = MenuCategory::get();

        return response()->json([
            'menu_category' => $item
        ], 200);
    }

    public function getPages () {
        $item = StaticPages::select('id','title_ru','description_ru')->where('status',1)->get();

        return response()->json([
            'pages' => $item
        ], 200);
    }

    public function getRoles () {
        $item = Role::get();

        return response()->json([
           'roles' => $item
        ],200);
    }

    public function insert (Request $request) {
        $answer = new MenuItem();
        $answer->title_kk = $request['title_kk'];
        $answer->title_ru = $request['title_ru'];
        $answer->id_menu = $request['id_menu'];
        $answer->role_id = $request['role_id'];
        $answer->type = $request['type'];
        if ($request['type'] === 1){
            $answer->id_page = $request['id_page'];
        }else if ($request['type'] === 2) {
            $answer->link = $request['link'];
        }else if ($request['type'] === 3) {
            $answer->link = $request['link'];
        }

        if( $answer->save() ){
            return response()->json([
               'answer' => 'success'
            ],200);
        }else{
            return response()->json([
                'answer' => 'not success'
            ],500);
        }
    }
    public function insertCategories (Request $request) {
        $answer = new MenuCategory();
        $answer->name_kk = $request['name_kk'];
        $answer->name_ru = $request['name_ru'];

        if( $answer->save() ){
            return response()->json([
               'answer' => 'success'
            ],200);
        }else{
            return response()->json([
                'answer' => 'not success'
            ],500);
        }
    }
    public function deleteCategories ($id) {
        $answer = MenuCategory::where('id',$id)->delete();
        if( $answer ){
            return response()->json([
                'item' => 'success'
            ],200);
        }else{
            return response()->json([
                'item' => 'fail'
            ],500);
        }
    }

    public function update (Request $request, $id) {
        $answer = MenuItem::where('id',$id)->first();
        $answer->title_kk = $request['title_kk'];
        $answer->title_ru = $request['title_ru'];
        $answer->id_menu = $request['id_menu'];
        $answer->role_id = $request['role_id'];
        $answer->type = $request['type'];
        if ($request['type'] === 1){
            $answer->id_page = $request['id_page'];
        }else if ($request['type'] === 2) {
            $answer->link = $request['link'];
        }else if ($request['type'] === 3) {
            $answer->link = $request['link'];
        }

        if( $answer->save() ){
            return response()->json([
                'answer' => 'success'
            ],200);
        }else{
            return response()->json([
                'answer' => 'not success'
            ],500);
        }
    }

    public function show ($id) {
        $answer = MenuItem::where('id',$id)->first();
        if( $answer ){
            return response()->json([
               'item' => $answer
            ],200);
        }else{
            return response()->json([
                'item' => 'fail'
            ],500);
        }
    }
    public function delete ($id) {
        $answer = MenuItem::where('id',$id)->delete();
        if( $answer ){
            return response()->json([
               'item' => $answer
            ],200);
        }else{
            return response()->json([
                'item' => 'fail'
            ],500);
        }
    }
    public function getItems ($name) {
        $check = Role::where('name',$name)->first();
        if ($check->level === 3) {
            $parentid = $check->parent_id;
            $parent = Role::where('id', $parentid)->first();
            $grandParent = Role::where('id', $parent->parent_id)->first();

            $rolesId = [$grandParent->id, $parent->id, $check->id, 1];

        }
        elseif($check->level === 2){
            $parentid = $check->parent_id;
            $parent = Role::where('id', $parentid)->first();

            $rolesId = [ $parent->id, $check->id, 1];

        }else{
            if($check->id !== 1){
                $rolesId = [ $check->id, 1 ];
            }else{
                $rolesId = [ $check->id ];
            }
        }

        $menu_items = array();

        for ($i = 0; $i < count($rolesId); $i++) {
            $items = MenuItem::where('role_id',$rolesId[$i])->get();
            for ($y = 0; $y < count($items); $y++ ){
                array_push($menu_items,$items[$y]);
            }

        }



        if( $menu_items ){
            return response()->json([
               'items' => $menu_items
            ],200);
        }else{
            return response()->json([
                'item' => 'fail'
            ],500);
        }
    }


}
