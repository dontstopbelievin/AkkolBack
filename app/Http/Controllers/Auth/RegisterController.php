<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'iin' => 'string|max:255|unique:users',
            'bin' => 'string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return array
     */
    protected function create(Request $request)
    {
        $valid = $this->validator($request->all());

        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);

            return $jsonError;
        }

        DB::beginTransaction();

        try {
            $data = $request->all();

            $user = User::create([
                'name' => implode(' ', [$data['last_name'], $data['first_name'], $data['middle_name']]),
                'email' => $data['email'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'company_name' => isset($data['company_name']) ? $data['company_name'] : null,
                'iin' => isset($data['iin']) ? $data['iin'] : null,
                'bin' => isset($data['bin']) ? $data['bin'] : null,
                'password' => bcrypt($data['password']),
            ]);

            $user->roles()->attach(Role::where('id', Role::TEMPORARY)->first());

            $client = DB::table('oauth_clients')->where('password_client', 1)->first();

            $result = [
                'grant_type'    => 'password',
                'client_id'     => $client->id,
                'client_secret' => $client->secret,
                'username'      => isset($data['bin']) ? $data['bin'] : $data['iin'],
                'password'      => $data['password'],
                'scope'         => null,
            ];

            DB::commit();

            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
