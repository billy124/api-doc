<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Illuminate\Http\Response as BaseResponse;
use App\User;
use JWTAuth;

class UserController extends Controller {

    // exclude controllers from auth
    protected $except = [
        'authenticate'
    ];
    // auto load data
    protected $load = [
    ];

    public function __construct() {
        $this->model = new User;
        $this->auth();
    }

    /**
     * This is the form authentication
     * @param Request $request
     * @return type
     */
    public function authenticate(Request $request) {
        try {
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response(['errors' => ['login' => 'Incorrect authentication details']], BaseResponse::HTTP_UNAUTHORIZED);
            }

            $user = User::where('email', '=', $request->get('email'))->first();

            return ['items' =>
                [
                    'token' => $token,
                    'user' => $user
                ]
            ];
        } catch (JWTException $e) {
            return response($e->getMessage(), BaseResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
