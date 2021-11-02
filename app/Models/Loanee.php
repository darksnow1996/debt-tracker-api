<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loanee extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = ['name','email','tel'];



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function loans(){
        return $this->hasMany(Loan::class);
    }
}
