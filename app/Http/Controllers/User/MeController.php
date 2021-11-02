<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MeController extends Controller
{
    public function getMe(){
       
            return response(['user' => auth()->user()], Response::HTTP_OK);
        

       
    }
}
