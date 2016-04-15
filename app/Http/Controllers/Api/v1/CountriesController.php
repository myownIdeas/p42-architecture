<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Requests\Country\AddCountryRequest;
use App\Http\Requests\Requests\Country\DeleteCountryRequest;
use App\Http\Requests\Requests\Country\GetAllCountriesRequest;
use App\Http\Requests\Requests\Country\UpdateCountryRequest;
use App\Http\Responses\Responses\ApiResponse;
use App\Repositories\Repositories\Sql\CountriesRepository;
use App\Transformers\Response\CountryTransformer;

class CountriesController extends ApiController
{
    private $countries = null;
    private $userTransformer = null;
    public $response = null;
    public function __construct
    (
        ApiResponse $response,CountryTransformer $countryTransformer,
        CountriesRepository $countriesRepository
    )
    {
        $this->countries =  $countriesRepository;
        $this->userTransformer = $countryTransformer;
        $this->response = $response;
    }
    public function store(AddCountryRequest $request)
    {
        $country =$request->getCountryModel();
        $country->id = $this->countries->store($country);
        return $this->response->respond(['data'=>['country' =>$country]]);
    }
    public function update(UpdateCountryRequest $request)
    {
        $country =$request->getCountryModel();
        $this->countries->store($country);
        return $this->response->respond(['data'=>['country' =>$country]]);
    }
    public function delete(DeleteCountryRequest $request)
    {
        return $this->response->respond(['data'=>[
            'country'=>$this->countries->delete($request->getCountryModel())
        ]]);
    }
    public function all(GetAllCountriesRequest $request)
    {
        return $this->response->respond(['data'=>[
            'country'=>$this->countries->all()
        ]]);
    }
}
