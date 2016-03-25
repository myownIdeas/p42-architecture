<?php
/**
 * Created by PhpStorm.
 * User: JR Tech
 * Date: 3/16/2016
 * Time: 1:46 PM
 */

namespace App\Http\Responses\Responses;

use App\Http\Responses\Interfaces\ResponseInterface;
use App\Http\Responses\Response as AppResponse;
use League\Flysystem\Config;

class ApiResponse extends AppResponse implements ResponseInterface
{
    public function __construct(){}


    /**
     * @param $response
     * @param $headers
     * @return json
     * @description
     * following function accepts data from
     * controllers and return a pre-setted view.
     **/
    public function respond(array $response, array $headers = []){
        $http_status = $this->getHttpStatus();
        $response['status'] = ($http_status == 200)?1:0;
        $response['message'] = (isset($data['message']))?$data['message']:(($response['status'] == 1)?config('constants.SUCCESS_MESSAGE'):config('constants.ERROR_MESSAGE'));
        $access_token = '';
        if(isset($response['access_token']))
            $access_token = $response['access_token'];
        else if(isset($response['data']) && isset($response['data']['user'])){
            $access_token = $response['data']['user']->access_token;
        }else{
            $access_token = $this->getAccessToken();
        }
        $response['access_token'] = $access_token;
        return response()->json($response, $this->getHttpStatus(), $headers);
    }

    public function getAccessToken(){
        return "iAmASuperSecureAccessToken";
    }

}