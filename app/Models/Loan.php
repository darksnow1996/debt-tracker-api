<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function loanee(){
        return $this->belongsTo(Loanee::class);
    }

    public function payments(){
        return $this->hasMany(LoanPayment::class);
    }
}
