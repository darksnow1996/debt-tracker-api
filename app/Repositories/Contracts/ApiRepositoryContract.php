<?php

namespace App\Repositories\Contracts;

interface ApiRepositoryContract {

    public function baseUrl($url);

    public function get($url, $data=[]);

    public function post($url, $data=[]);

    public function put($url, $data=[]);


}