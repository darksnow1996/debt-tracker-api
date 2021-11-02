<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ContactFormSubmitted;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class ContactController extends Controller
{

    public $contacts;
    public function __construct( ContactRepository $contacts )
    {
        $this->contacts = $contacts;        
    }


    public function create(Request $request){
        try{
            $this->validate($request, [
                'name' => 'required|string|min:3',
                'email' => 'required|string|email',
                'description' => 'required|string|min:20'
            ]);

            $contact = $this->contacts->create([
                'name' => $request->name,
                'email' => $request->email,
                'desc' => $request->description
            ]);
           // dd($contact->email);

            //send notification to admin
        //     $user = User::where("email", "oluyemodamola@gmail.com")->first();
        //    // dd($user);
        //    $user->notify(new ContactFormSubmitted($contact));

            return response([
                'message' => 'Contact form submitted'
            ], Response::HTTP_OK);

        }
        catch(ValidationException $e){
            return response([
                'message' => "The given data is invalid",
                'errors' => $e->errors()
                
            ],Response::HTTP_NOT_ACCEPTABLE);

        }
    }
}
