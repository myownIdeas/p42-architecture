<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requests\Auth\AuthenticationRequest;
use App\Http\Requests\Requests\Auth\LoginRequest;
use App\Http\Requests\Requests\Auth\RegistrationRequest;
use App\Http\Responses\Responses\ApiResponse;
use App\Libs\Auth\Api as Authenticator;
use App\Models\Sql\User;
use App\Repositories\Interfaces\Repositories\UsersRepoInterface;
use App\Repositories\Repositories\Sql\UsersRepository;
use App\Transformers\Response\UserTransformer;

class AuthController extends Controller
{
    private $auth;
    private $users;
    private $userTransformer;
    public $response;
    public function __construct
    (
        ApiResponse $response, Authenticator $authenticator,
        UsersRepoInterface $usersRepository, UserTransformer $userTransformer
    )
    {
        $this->auth = $authenticator;
        $this->users = $usersRepository;
        $this->response = $response;
        $this->userTransformer = $userTransformer;
    }
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if(!$this->auth->attempt($credentials))
            return $this->response->respondInvalidCredentials();

        $authenticatedUser = $this->auth->login(['email'=>$credentials['email']]);
        if($authenticatedUser == null)
            $this->response->respondInternalServerError();

        return $this->response->respond(['data'=>[
            'authUser' => $authenticatedUser
        ]]);
    }

    public function register(RegistrationRequest $request)
    {
        $userId = $this->users->store($request->getUserInfo());

        if($userId == null)
            return $this->response->respondInternalServerError();

        if($request->userIsAgent())
            if(!$this->storeAgency($request->getAgencyInfo(), $userId))
                return $this->response->respondInternalServerError();

        $response = ['data'=>[
            'user'=>$this->userTransformer->transformDocument($this->users->getUserDocument($userId))
        ]];

        return $this->response->respond($response);
    }
}
