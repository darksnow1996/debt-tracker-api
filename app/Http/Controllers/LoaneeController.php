<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanCollection;
use App\Http\Resources\LoaneeCollection;
use App\Repositories\LoaneeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoaneeController extends Controller
{
    public $loanee;
    public function __construct(LoaneeRepository $loanee)
    {
        $this->loanee = $loanee;
    }

    public function createLoanee(Request $request){
        $request->validate([
            'name' => ['required']
        ]);
        $user = Auth::user();
        $name = strtolower($request->name);

        $user->loanees()->create([
            'name' => $name,
            'email' => $request->email,
            'tel' => $request->tel
        ]);

        return response([
            'message' => 'Laonee record added successfully'
        ]);
    }

    public function getLoanees(){
        $user = auth()->user();
        $loanees = $user->loanees()->get();
        return new LoaneeCollection($loanees);

    }

    public function getLoanee(){

    }

    public function updateLoanee(){

    }
}
