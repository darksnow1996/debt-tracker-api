<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        try{
            
            $userExist = User::where([
                'email' => $request->email,
               
            ])->exists();
            if($userExist){
                return response([
                    'message' => 'User exists already'
                ], Response::HTTP_NOT_ACCEPTABLE);
            }
            $user = User::create([
                'firstname' => strtolower($request->firstname),
                'lastname' => strtolower($request->lastname),
                'email' => strtolower($request->email),
                // 'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);

            event(new Registered($user));
    
            return response([ 'user'=> $user, 'message' => 'Registration successful'], Response::HTTP_CREATED);

        }
        catch(Exception $e){
            return response(['message' => $e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        

    }

    public function login(LoginRequest $request){
        try{
        $isCorrect = Auth::attempt([
            'email' => strtolower($request->email),
            'password' => $request->password
        ]);
        if(!$isCorrect){
            return response(['error' =>
            'Invalid credentials'
            
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $jwtCookie = cookie('jwt', $token,60*24);

        return response([
            'user' => $user,
            'token' => $token
        ], Response::HTTP_OK)->withCookie($jwtCookie);
    }
    catch(Exception $e){
        return response(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    }

    public function logout(){
        $cookie = Cookie::forget('jwt');

        return response([
        'message' => 'logout successfull'
        ], Response::HTTP_OK)->withCookie($cookie);

    }

    public function checkAuthStatus(){
        
        return response(['message' => 'logged in'], Response::HTTP_OK);
              
    }
}
