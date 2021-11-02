<?php
namespace App\Repositories;

use App\Repositories\Contracts\ApiRepositoryContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ApiRepository implements ApiRepositoryContract{

    protected $token;
    protected $attachToken;
    public $http;

    public function __construct(){
        $this->token = config('app.data_token');
        $this->http = Http::class;
        $this->attachToken = [
            'api_token' => $this->token
        ];
    }
    

    public function get($url, $data=[]){
       // dd($this->token); 
     // return Arr::add($data, 'api_token', $this->token);      
    // dd(Arr::add($data, 'api_token', $this->token));
     return json_decode(Http::get($url, Arr::add($data, 'api_token', $this->token))->body());
    }

    public function post($url, $data=[]){

        return Http::post($url,Arr::add($data, 'api_token', $this->token))->json();
    }

    public function put($url, $data=[]){
        return Http::put($url,Arr::add($data, 'api_token', $this->token))->json();

    }

    public function baseUrl($url)
    {
        return url(config('app.api_base_url').$url);
    }


}