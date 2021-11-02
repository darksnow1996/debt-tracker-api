<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|min:3|string',
            'lastname' => 'required|min:3|string',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'phone' => ['required','numeric','digits:11', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                // 'regex:/[a-z]/',      // must contain at least one lowercase letter
                // 'regex:/[A-Z]/',      // must contain at least one uppercase letter
                // 'regex:/[0-9]/',      // must contain at least one digit
                // 'regex:/[@$!%*#?&]/', 
                'confirmed',                    // must contain a special character
            ],
        ];
    }

    public function messages()
    {
        return [
            'password' => [
                'regex' => 'Password must contain at least one lowercase letter',      // must contain at least one lowercase letter
                
            ]
            
        ];
    }
}
