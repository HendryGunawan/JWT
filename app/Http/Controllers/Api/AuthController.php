<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTAuthException;

class AuthController extends Controller
{
    private $user;
    private $jwtauth;
    private $field = ['email', 'password'];


    public function __construct() {
       $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    // public function register(RegisterRequest $request)
    // {
    //     $newUser = $this->user->create([
    //         'name' => $request->get('name'),
    //         'email' => $request->get('email'),
    //         'password' => bcrypt($request->get('password'))
    //     ]);

    //     if (!$newUser) {
    //         return response()->json(['failed_to_create_new_user'], 500);
    //     }

    //     return response()->json([
    //         'token' => $this->jwtauth->fromUser($newUser)
    //     ]);
    // }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only($this->field);
        $token = null;

        try {
            $token = $this->jwtauth->attempt($credentials, $credentials);
            if (!$token) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function authenticate(Request $request) {
        $credentials = $request->only($this->field);

        try {
            if (!$token = JWTAuth::attempt($credentials, $credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser() {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
            // if (!$user = JWTAuth::parseToken()->getPayload()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
        return response()->json(compact('user'));
    }

    public function decode() {
        try {
            // if (!$user = JWTAuth::parseToken()->authenticate()) {
            if (!$user = JWTAuth::parseToken()->getPayload()) {
                return response()->json(['user_not_found'], 404);
            }
            
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
        return $user;
    }

    public function register(Request $request) {
        $newuser = $request->all();
        $password = bcrypt($request->input('password'));
        $newuser['password'] = $password;
        return User::create($newuser);
    }

    public function getUser() {
       return response()->json(User::all());
    }
}
