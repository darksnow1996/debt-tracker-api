<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class FixtureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'teams' => [
                'localteam' => $this->when($request->include && Str::contains($request->include, ["localteam"]),new TeamResource($this->localteam)),
                'visitorteam' => $this->when($request->include && Str::contains($request->include, ["visitorteam"]),new TeamResource($this->visitorteam)), 
            ],
            'scores' => $this->when($request->include && Str::contains($request->include, ["scores"]), [
                "localteam_score" => $this->localteam_score,
                "visitorteam_score" => $this->visitorteam_score,
                "localteam_pen_score" => $this->localteam_pen_score,
                "visitorteam_pen_score" => $this->visitorteam_pen_score,
                "ht_score" => $this->ht_score,
                "ft_score" => $this->ft_score,
                "ps_score" => $this->ps_score,
                "et_score" => $this->et_score,

            ]),
            'time' => [
                "starting_at" => [
                    "date_time" => $this->date_time,
                    "date" => $this->start_date,
                    "time" => $this->start_time
                ],
                "minute" => $this->minute,
                "second" => $this->second,
                "added_time" => $this->added_time,
                "extra_time" => $this->extra_time,
                "injury_time" => $this->injury_time,



            ],
            'positions' => [
                "localteam_position"=> $this->localteam_position,
                "visitorteam_positiom" => $this->visitorteam_positiom

            ],
            'formations' => [
                "localteam_formation" => $this->localteam_formation,
                "visitorteam_formation" => $this->visitorteam_formation
            ],
            'colors' => [
                "localteam_color" => $this->localteam_color,
                "visitorteam_color" => $this->visitorteam_color

            ],
            'league' => $this->when($request->include && Str::contains($request->include, ["league"]), new LeagueResource($this->league)),
            'season' => $this->when($request->include && Str::contains($request->include, ["season"]), new SeasonResource($this->season)),
            'stage' => $this->when($request->include && Str::contains($request->include, ["stage"]), new StageResource($this->stage)),
            'round' => $this->when($request->include && Str::contains($request->include, ["round"]), new RoundResource($this->round)),
            'venue' => $this->when($request->include && Str::contains($request->include, ["venue"]), new VenueResource($this->venue))

        ];
    }
}
