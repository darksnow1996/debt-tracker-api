<?php

namespace App\Http\Controllers\auth;

use App\Actions\Fortify\CompletePasswordReset;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Responses\FailedPasswordResetResponse;
use App\Http\Responses\PasswordResetResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Http\Controllers\NewPasswordController as ControllersNewPasswordController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


use Laravel\Fortify\Contracts\ResetsUserPasswords;


class NewPasswordController extends Controller
{

    //protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    

    
    public function store(NewPasswordRequest $request)
    {
        
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
        if ($status == Password::INVALID_TOKEN) {
            return response()->json(["message" => "Invalid token provided"], 422);
        }

        return response()->json(["message" => "Password has been successfully changed"],200);
    }
}
