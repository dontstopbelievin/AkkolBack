<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Response;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;

class AccessTokenController extends ATC
{
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            //get username (default is :email)
            $username = $request->getParsedBody()['username'];

            //get user
            $user = User::where('iin', '=', $username)->first();
            $roles = $user->roles;

            //generate token
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"]))
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);

            //add access token to user
            $user = collect($user);

            foreach ($roles as $key => $value) {
                $user->put('role' . ($key + 1), $value->name);
            }

            $user->put('access_token', $data['access_token']);

            return response()->json($user);
        }
        catch (ModelNotFoundException $e) { // email notfound
            //return error message
            return response(["message" => "User not found"], 500);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
            return response(["message" => "The user credentials were incorrect.', 6, 'invalid_credentials"], 500);
        }
        catch (Exception $e) {
            ////return error message
            return response(["message" => "Internal server error"], 500);
        }
    }
}