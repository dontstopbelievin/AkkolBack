<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Parser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'userInfo']);
    }

    /**
     * Get username
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    /**
     * Logout
     *
     * @return array
     */
    public function logout(Request $request)
    {
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');

        DB::table('oauth_access_tokens')
            ->where('id', '=', $id)
            ->update(['revoked' => true]);

        $this->guard()->logout();

        $json = [
            'success' => true,
            'code' => 200,
            'message' => 'You are Logged out.',
        ];

        return response()->json($json, '200');
    }

    /**
     * Get user info
     *
     * @return array
     */
    public function userInfo()
    {
        if (!Auth::guard('api')->user()) {
            return response()->json('Пользователь не авторизован', '401');
        }

        $token = Auth::guard('api')->user()->token();

        if (strtotime($token->expires_at) <= time()) {
            $token->revoked = true;
            $token->save();

            $this->guard()->logout();

            return response()->json('Пользователь не авторизован', '401');
        }

        $json = [
            'name' => Auth::guard('api')->user()->name
        ];

        return response()->json($json, '200');
    }
}
