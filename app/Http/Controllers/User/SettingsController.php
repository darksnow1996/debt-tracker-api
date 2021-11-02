<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\UpdateCoaches;
use App\Jobs\UpdatePlayers;
use App\Jobs\UpdatePrediction;
use App\Jobs\UpdateStages;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Fixture;
use App\Models\Season;
use App\Models\Team;
use App\Models\Venue;
use App\Repositories\CoachRequestRepository;
use App\Repositories\ContinentRequestRepository;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\CountryRequestRepository;
use App\Repositories\FixtureRequestRepository;
use App\Repositories\LeagueRequestRepository;
use App\Repositories\RoundRequestRepository;
use App\Repositories\SeasonRequestRepository;
use App\Repositories\StageRequestRepository;
use App\Repositories\TeamRequestRepository;
use App\Repositories\VenueRequestRepository;
use App\Rules\MatchOldPassword;
use App\Rules\NewPasswordMustBeDifferent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{

    protected $users;
    protected $continents;

    public function __construct()
    {
       
        
    }

    public function updateProfile(Request $request){
        try{
        $this->validate($request, [
            'firstname' => 'required|string|min:3',
            'lastname' => 'required|string|min:3'
        ]);
        $user = auth()->user();

        $user->firstname =  $request->firstname;
        $user->lastname = $request->lastname;
        $user->profile_picture_path = $request->profile_photo ? $request->profile_photo: $user->profile_picture_path;
        $user->phone = $request->phone ? $request->phone: $user->phone;

        $user->save();

        // $user->update([
        //     'firstname' => $request->firstname,
        //     'lastname' => $request->lastname,
        //     'profile_picture_path' => $request->profile_photo
        // ]);
        
        return response([
            'message' => "profile updated successfully",
            'data' => new UserResource($user)
        ],Response::HTTP_OK);
        }
        catch(ValidationException $e){
            return response([
                'message' => "The given data is invalid",
                'errors' => $e->errors()
                
            ],Response::HTTP_NOT_ACCEPTABLE);

        }
        catch(Exception $e){
            return response([
                'message' => $e->getMessage(),
                
            ],Response::HTTP_INTERNAL_SERVER_ERROR);

        }



    }

    public function updatePassword(Request $request){
        try{
            $this->validate($request, [
                'current_password' => ['required','string','min:6',new MatchOldPassword],
                'password' => ['required','string','min:6','confirmed', new NewPasswordMustBeDifferent]
            ]);
            //added comment
            $user = auth()->user();
    
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            
            return response([
                'message' => "password updated successfully",
                
            ],Response::HTTP_OK);
            }
            catch(ValidationException $e){
                return response([
                    'message' => "The data provided is invalid",
                    'errors' => $e->errors()
                    
                ],Response::HTTP_NOT_ACCEPTABLE);
    
            }
            catch(Exception $e){
                return response([
                    'message' => $e->getMessage(),
                    
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
    
            }
    

    }

    public function test(Team $teams, TeamRequestRepository $teamApiData, Season $seasons){
        $seasons = $seasons->where("is_current_season", true)->get();
        // dd($seasons);

        foreach($seasons as $season){

            $teamApiData1 = $teamApiData->getTeamsBySeason($season->id);    
          //  dd($teamApiData1);
            
            if(isset($teamApiData1->meta)){
                $totalRecords = $teamApiData1->meta->pagination->total;
                $noOfPages = $teamApiData1->meta->pagination->total_pages;
    
         
                for($i=1; $i <= $noOfPages; $i++){
             
                     $teamApiData2 = $teamApiData->getTeamsBySeason($season->id, $i)->data;
    
                     foreach($teamApiData2 as $team){
                        if(!$teams->where("id",$team->id)->exists()){
              //  $continent = $country->continent->data->id;
                            $teams->create([
                                    'id' => $team->id,
                                    'name' => $team->name,
                                    'twitter' => $team->twitter,                
                                    'country_id' => $team->country_id,
                                    'short_code' => $team->short_code,
                                    'legacy_id' => $team->legacy_id,
                                    'national_team' => $team->national_team,
                                    'founded' => $team->founded,
                                    'venue_id' => $team->venue_id,
                                    'current_season_id' => $team->current_season_id,
                                    'is_placeholder' => $team->is_placeholder,
                                    'coach_id' => isset($team->coach) ? $team->coach->data->coach_id:null,
                                    'logo_path' => $team->logo_path
    
                                    
    
                                ]);
    
           
                     }
             else{
            $teams->where("id",$team->id)->update([
                'id' => $team->id,
                'name' => $team->name,
                'twitter' => $team->twitter,                
                'country_id' => $team->country_id,
                'short_code' => $team->short_code,
                'legacy_id' => $team->legacy_id,
                'national_team' => $team->national_team,
                'founded' => $team->founded,
                'venue_id' => $team->venue_id,
                'current_season_id' => $team->current_season_id,
                'is_placeholder' => $team->is_placeholder,
                'coach_id' => isset($team->coach) ? $team->coach->data->coach_id:null,
                'logo_path' => $team->logo_path
    
                
    
            ]);
           }
           if(isset($team->coach)){
            $updateCoach = dispatch_sync(new UpdateCoaches($team->coach->data->coach_id));
           }
          
        }
    
    
    
           }

            }
           
        }
        
        
}
}




