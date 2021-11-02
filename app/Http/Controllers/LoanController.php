<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanCollection;
use App\Repositories\LoaneeRepository;
use App\Repositories\LoanRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoanController extends Controller
{
   public $loan;
   public $loanee;
    public function __construct(LoanRepository $loan, LoaneeRepository $loanee)
    {
        $this->loan = $loan;
        $this->loanee = $loanee;
    }


    public function createLoan(Request $request){
        $request->validate([
            'loanee_id' => ['required']
        ]);
        $loaneeId = $request->loanee_id;

        $loanee = $this->loanee->findWhereFirst([
            'id' => $loaneeId
        ]);

        if(!$loanee){
            return response([
                'message' => 'Loanee records does not exist'
            ], Response::HTTP_NOT_FOUND);
        }

        $loan = $loanee->loans()->create([
            'amount'=> $request->amount,
            'date_collected'=> Carbon::parse($request->date_collected),
            'payback_date'=> Carbon::parse($request->payback_date),
            
        ]);

        return response([
            'message' => 'Loan record created successfully'
        ], Response::HTTP_OK);


    }

    public function getLoans(){
        $user = auth()->user();
        $loans = $user->loans()->get();
        return new LoanCollection($loans);
    }
}
