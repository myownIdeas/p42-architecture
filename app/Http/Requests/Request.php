<?php

namespace App\Http\Requests;

use App\Transformers\Transformer;

abstract class Request
{
    private $transformedValues = [];
    private $transformer = null;
    public function __construct(Transformer $transformer){
        $this->transformer = $transformer;
        $this->transformedValues = $this->transformer->transform(request()->all());
    }

    public function get($key){
        return (isset($this->transformedValues[$key]))?$this->transformedValues[$key]:null;
    }

    public function getOriginal($key){
        return request()->get($key);
    }

    public function all(){
        return $this->transformedValues;
    }

    public function allOriginal(){
        return request()->all();
    }

    public function getOriginalRequest()
    {
        return request();
    }

    public function authenticate(){
        return true;
    }
}
