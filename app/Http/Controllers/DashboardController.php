<?php

namespace App\Http\Controllers;

use App\Repositories\LoaneeRepository;
use App\Repositories\LoanRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public $loans;
    public $loanees;
    public function __construct(LoanRepository $loans, LoaneeRepository $loanees)
    {
        $this->loans = $loans;
        $this->loanees = $loanees;        
    }


    public function getDashboardData(){
        $user = auth()->user();
        $totalAmountLoaned = $user->loans->sum("amount");
       $totalAmountReceived = $user->loanpayments()->sum("amount_paid");
        $lastPaymentReceived = $user->loanpayments()->orderBy("created_at","desc")->first();
        $lastLoanGiven = $user->loans()->orderBy("date_collected","desc")->with("loanee") ->first();
        $highestLoanee = $user->loans()->groupBy('loanee_id')
        ->orderByRaw('SUM(amount) DESC')->with("loanee")
        ->first();

        return response()->json(["data" => [
            'totalAmountLoaned' => $totalAmountLoaned,
            'totalAmountReceived' => $totalAmountReceived,
            'highestLoanee' => $highestLoanee,
            'lastPaymentReceived' => $lastPaymentReceived,
            'lastLoanGiven' => $lastLoanGiven



        ]], Response::HTTP_OK);
      // dd($totalAmountLoaned);


    }
}
