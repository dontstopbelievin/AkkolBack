<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
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

    public function getTokenXml()
    {
        $client = new Client();

        $response = $client->get('http://89.218.17.203:3380/getTokenXml');

        return response(json_decode($response->getBody()), 200);
    }

    public function loginWithCert(Request $request)
    {
        $client = new Client();

        $response = $client->post('http://89.218.17.203:3380/loginWithECP', [
            'form_params' => [
                'XmlDoc' => $request->XmlDoc
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        $result = [];

        $iin_pos = strpos($data['KC_CERTPROP_SUBJECT_DN'], 'IIN');
        $bin_pos = strpos($data['KC_CERTPROP_SUBJECT_DN'], 'BIN');
        $email_pos = strpos($data['KC_CERTPROP_SUBJECT_DN'], 'emailAddress=');
        $name = explode(' ', substr($data['KC_CERTPROP_SUBJECT_COMMONNAME'], 3));

        $result['first_name'] = mb_convert_case($name[1], MB_CASE_TITLE);
        $result['last_name'] = mb_convert_case($name[0], MB_CASE_TITLE);
        $result['middle_name'] = mb_convert_case(substr($data['KC_CERTPROP_SUBJECT_GIVENNAME'], 3), MB_CASE_TITLE);
        $result['email'] = mb_strtolower(substr($data['KC_CERTPROP_SUBJECT_DN'], $email_pos + strlen('emailAddress=')));

        if ($bin_pos) {
            $result['bin'] = substr($data['KC_CERTPROP_SUBJECT_DN'], $bin_pos + 3, 12);
        } else if ($iin_pos) {
            $result['iin'] = substr($data['KC_CERTPROP_SUBJECT_DN'], $iin_pos + 3, 12);
        } else {
            return response(['message' => 'ИИН/БИН не найден'], 404);
        }

        return response($result, 200);
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
