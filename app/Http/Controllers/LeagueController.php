<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeagueCollection;
use App\Repositories\LeagueRepository;
use Illuminate\Http\Request;

class LeagueController extends Controller
{

    public $league;
    public function __construct(LeagueRepository $league)
    {
        $this->league = $league;

        
    }

    public function getAllLeagues(){
        $leagues = $this->league->all();

        return new LeagueCollection($leagues);
    }
}
