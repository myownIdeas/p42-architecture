<?php
/**
 * Created by PhpStorm.
 * User: JR Tech
 * Date: 3/16/2016
 * Time: 9:55 AM
 */

namespace App\Libs\Auth;


use App\Libs\Auth\Traits\TokenGenerator;

class Api extends Authenticate implements AuthInterface
{
    use TokenGenerator;

    private $accessToken = null;

    public function __construct(){}

    public function login(array $credentials , $usersRepo){
        $this->setAccessToken($this->generateToken($credentials));
        $authenticatedUser = $usersRepo->getFirst($credentials);
        $authenticatedUser->access_token = $this->getAccessToken();

        if(!$usersRepo->updateUser($authenticatedUser))
            return false;

        return $authenticatedUser;
    }

    /**
     * @return null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param null $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }


}