<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\News;
use App\PersonalData;
use App\Role;
use App\User;
use App\RoleUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Hash;

class UserTableController extends Controller
{


    public function allUsers () {
        $answer = User::get();

        if ( $answer != '' ){
            return response()->json([
                'users' => $answer
            ], 200);
        }else{
            return response()->json([
                'error' => 'Fail to get users from database'
            ], 500);
        }
    }

    public function deleteUsers ($id) {
        $answer = RoleUsers::where('user_id',$id)->delete();

        if ( $answer ){
            $userNewRole = new RoleUsers();
            $userNewRole->user_id = $id;
            $userNewRole->role_id = 1;
        }

        if( $userNewRole->save() ){
            $answer = RoleUsers::get();

            if ( $answer != '' ){
                return response()->json([
                    'roleUser' => $answer
                ], 200);
            }else{
                return response()->json([
                    'error' => 'Fail to get role from roles'
                ], 500);
            }
        }else{
            return response()->json([
                'error' => 'fail'
            ], 500);
        }

    }

    public function getRoles () {
        $answer = Role::get();

        if ( $answer != '' ){
            return response()->json([
                'roles' => $answer
            ], 200);
        }else{
            return response()->json([
                'error' => 'Fail to get users from database'
            ], 500);
        }
    }

    public function getUserRoles () {
        $answer = RoleUsers::get();

        if ( $answer ){
            return response()->json([
                'roleUser' => $answer
            ]);
        }else{
            return response()->json([
               'error' => 'fail'
            ]);
        }

    }

    public function addRoleToUser (Request $request){
        $answer = RoleUsers::where('user_id',$request['userid'])->delete();

        if ( $answer ) {
            $check = Role::where('id', $request['roleid'])->first();
            if ($check->level === 3) {
                $parentid = $check->parent_id;
                $parent = Role::where('id', $parentid)->first();
                $grandParent = Role::where('id', $parent->parent_id)->first();

                $rolesId = [$grandParent->id, $parent->id, $check->id];

            }
            elseif($check->level === 2){
                $parentid = $check->parent_id;
                $parent = Role::where('id', $parentid)->first();

                $rolesId = [ $parent->id, $check->id];

            }else{
                $rolesId = [ $check->id ];
            }

            for ($i = 0; $i < count($rolesId); $i++) {
                $addRole = new RoleUsers();
                $addRole->user_id = $request['userid'];
                $addRole->role_id = $rolesId[$i];
                if (!$addRole->save()) {
                    return response()->json([
                        'error' => 'fail in saving to role_user!'
                    ], 500);
                    break;
                }
            }

            $answer = RoleUsers::get();

            if ( $answer != '' ){
                return response()->json([
                    'roleUser' => $answer
                ], 200);
            }else{
                return response()->json([
                    'error' => 'Fail to get role from roles'
                ], 500);
            }

        }else{
            return response()->json([
                'error' => 'fail to delete in role_user!'
            ]);
        }
    }
}
