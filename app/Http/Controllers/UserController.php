<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Illuminate\Http\Response as BaseResponse;
use App\User;
use App\Models\Company;
use JWTAuth;
use Validator;
use App\Services\UserService;

class UserController extends Controller {

    // exclude controllers from auth
    protected $except = [
        'authenticate', 'store'
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
            return response(['errors' => $e->getMessage()], BaseResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request, $id = null) {
        try {
            $validator = Validator::make($request->all(), $this->model->rules(), $this->model->messages());

            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->getMessages()], BaseResponse::HTTP_UNAUTHORIZED);
            }

            $company = Company::findOrFail($request->get('company_id'));
            $user = User::create($request->all());

            $user->companies()->attach($company->id);

            return $user;
        } catch (JWTException $e) {
            return response(['errors' => $e->getMessage()], BaseResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function update(Request $request, $id = null) {
        try {
            $user = UserService::getAuthenticatedUser();

            if ($request->has('email')) {
                $validator = Validator::make($request->all(), $this->model->updateRules($user->id), $this->model->messages());

                if ($validator->fails()) {
                    return response(['errors' => $validator->errors()->getMessages()], BaseResponse::HTTP_UNAUTHORIZED);
                }
            }

            $user->fill($request->all());
            $user->update();

            return parent::show($user->id);
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], BaseResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
