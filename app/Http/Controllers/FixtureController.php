<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\FixtureCollection;
use App\Http\Resources\FixtureResource;
use App\Http\Resources\Head2HeadCollection;
use App\Repositories\Contracts\FixtureRepositoryContract;
use App\Repositories\FixtureRepository;
use App\Repositories\FixtureRequestRepository;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class FixtureController extends Controller
{

    public $fixture;
    public function __construct( FixtureRepository $fixture )
    {
        $this->fixture = $fixture;
        
    }


    public function getAllFixtures(Request $request){
        $fixtures = $this->fixture->getAllFixtures($request);

        return new FixtureCollection($fixtures);
    }

    public function getFixtureById($id){
        try{

            // dd($id);
        $fixture = $this->fixture->getFixtureById($id);
        // dd($fixtures);
 
        if(!$fixture){
            return response([
                "message" => "Fixture not found"
            ], Response::HTTP_NOT_FOUND);
        }
         return new FixtureResource($fixture);

        }
        catch(Exception $e){
            return response([
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
       
    }

    public function getFixturesByDate($date, Request $request){
        $fixtures = $this->fixture->getFixturesByDate($date, $request);

        return new FixtureCollection($fixtures);

    }

    public function getFixturesByDateRange($start, $end, Request $request){
        //dd(explode(",", $request->include));
        $fixtures = $this->fixture->getFixturesByDateRange($start, $end, $request);

        return new FixtureCollection($fixtures);

    }

    public function getFixturesByDateRangeTeam($start, $end, $teamId, Request $request){
        $fixtures = $this->fixture->getFixturesByDateRangeTeam($start, $end, $teamId, $request);

        return new FixtureCollection($fixtures);

    }

    public function getHead2Head($firstTeam, $secondTeam,Request $request,FixtureRequestRepository $head2head){

        try{
            $head2headData = $head2head->getHead2Head($firstTeam,$secondTeam,[
                'include' => $request->include
            ]);

            return response()->json($head2headData, Response::HTTP_OK);

        }
        catch(Exception $e){
            return new ErrorResource($e);
        }

       

    }
}
