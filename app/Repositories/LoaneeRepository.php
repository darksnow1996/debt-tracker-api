<?php

namespace App\Repositories;


use App\Models\Loanee;


class LoaneeRepository extends BaseRepository{

    

    protected function model(){

        return Loanee::class;
    }

    // public function getPredictions($request=null){
    //     $limit = $request->limit ? $request->limit:10;
    //     $predictions = $this->model
       
    //     ->when($request && $request->fixtures, function($query) use($request){
    //         return $query->whereIn("fixture_id", explode(",", $request->fixtures));
    //     })
    //     ->whereHas("fixture", function($query) use($request){

    //         $query->whereDate("date_time",">=", Carbon::today())
    //         ->when($request && $request->leagues, function($query) use($request){
    //             return $query->whereIn("league_id", explode(",", $request->leagues));
    //         })
    //         ->when($request && $request->statuses, function($query) use($request){
    //             return $query->whereIn("status", explode(",", $request->statuses));
    //         });
    //     })
    //     ->paginate($limit);

    //     return $predictions;
    // }

    // public function getPredictionsByDate($date, $request=null){
    //     $limit = $request->limit ? $request->limit:10;
    //     $predictions = $this->model
    //     ->when($request && $request->fixtures, function($query) use($request){
    //         return $query->whereIn("fixture_id", explode(",", $request->fixtures));
    //     })
    //     ->whereHas("fixture", function($query) use($date,$request){
    //         $query->whereDate("date_time", $date)
    //         ->when($request && $request->leagues, function($query) use($request){
    //             return $query->whereIn("league_id", explode(",", $request->leagues));
    //         })
    //         ->when($request && $request->statuses, function($query) use($request){
    //             return $query->whereIn("status", explode(",", $request->statuses));
    //         });
    //     })
    //     ->paginate($limit);

    //     return $predictions;
    // }

    // public function getPredictionsByDateRange($start,$end, $request=null){
    //     $limit = $request->limit ? $request->limit:10;
    //     $predictions = $this->model
    //     ->when($request && $request->fixtures, function($query) use($request){
    //         return $query->whereIn("fixture_id", explode(",", $request->fixtures));
    //     })
    //     ->whereHas("fixture", function($query) use($start,$end,$request){
    //         $query->whereDate("date_time",">=", $start)
    //         ->whereDate("date_time","<=", $end)
    //         ->when($request && $request->leagues, function($query) use($request){
    //             return $query->whereIn("league_id", explode(",", $request->leagues));
    //         })
    //         ->when($request && $request->statuses, function($query) use($request){
    //             return $query->whereIn("status", explode(",", $request->statuses));
    //         });
    //     })
    //     ->paginate($limit);

    //     return $predictions;
    // }


   

}