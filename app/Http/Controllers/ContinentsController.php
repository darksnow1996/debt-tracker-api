<?php

namespace App\Http\Controllers;

use App\Repositories\ContinentRequestRepository;
use Illuminate\Http\Request;

class ContinentsController extends Controller
{

    protected $continentsData;

    public function __construct(ContinentRequestRepository $continentsData)
    {
        $this->continentsData = $continentsData;        
    }    

    public function fetchContinents(){
        
    }
}
