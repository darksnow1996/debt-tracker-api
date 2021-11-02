<?php

namespace App\Http\Controllers;

use App\Http\Resources\InHousePredictionCollection;
use App\Http\Resources\InHousePredictionResource;
use App\Http\Resources\PredicitionBundleResource;
use App\Http\Resources\PredictionCategoryCollection;
use App\Http\Resources\PredictionCategoryResource;
use App\Http\Resources\PredictionCollection;
use App\Http\Resources\PredictionTypeCollection;
use App\Http\Resources\PredictionTypeResource;
use App\Repositories\BundleItemRepository;
use App\Repositories\InHousePredictionRepository;
use App\Repositories\PredictionBundleRepository;
use App\Repositories\PredictionCategoryRepository;
use App\Repositories\PredictionRepository;
use App\Repositories\PredictionTypeRepository;
use App\Rules\CheckIfFixtureExists;
use App\Rules\CheckIfFixtureExistsInHouse;
use App\Rules\CheckIfPredictionBundleExists;
use App\Rules\CheckIfPredictionTypeExists;
use App\Rules\CheckNoOfMatchesInBundle;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use NumberFormatter;
use Symfony\Component\HttpFoundation\Response;

class PredictionsController extends Controller
{
    public $prediction;
    public $inHousePrediction;
    public $category;
    public $predictionTypes;
    public function __construct( InHousePredictionRepository $inHousePrediction, PredictionRepository $prediction, PredictionCategoryRepository $category, PredictionTypeRepository $predictionTypes )
    {
        $this->prediction = $prediction;
        $this->inHousePrediction = $inHousePrediction; 
        $this->predictionTypes = $predictionTypes;
          
        $this->category = $category;    
    }

   


    public function getPredictionTypes(){
        $predictionTypes = $this->predictionTypes->all();
        return new PredictionTypeCollection($predictionTypes);
            }

    public function createPredictionType(Request $request){
                
            $this->validate($request, [
                'name' => 'required|string',
                'description' => 'required|string'
            ]); 
            $name = $request->name;
            $description = $request->description;
            $predictionType = $this->predictionTypes->create([
                'name' => $name,
                'desc' => $description
            ]);    
            
            return response([
                'data' => new PredictionTypeResource($predictionType),
                'message' => 'Prediction Type created'
            ], Response::HTTP_OK);
       
      

    }

    public function getPredictionCategories(){
        $predictionBundles = $this->category->all();
        return new PredictionCategoryCollection($predictionBundles);
    }


    public function createPredictionCategory(Request $request){
        $this->validate($request,[
            'name' => ['required', 'string'],
            'code' => ['required', 'unique:prediction_categories' ],
            'matches' => ['required','integer', new CheckIfPredictionBundleExists]
        ]);
        $name = $request->name;
        $code = $request->code;
        $matches = $request->matches;
        $predictionBundle = $this->category->create([
            'name' => $name,
            'code' => $code,
            'matches' => $matches
        ]);

        return response([
            'data' => new PredictionCategoryResource($predictionBundle),
            'message' => 'Prediction Type created'
        ], Response::HTTP_OK);

    }

    public function createSingleTip(Request $request){
        //check if fixture has not been played
        $this->validate($request, [
            'prediction_type' => ['required', 'integer'],
            'fixture_id' => ['required', 'integer', new CheckIfFixtureExists, new CheckIfFixtureExistsInHouse($request->prediction_type)],
           
            
           
        ]);
        $fixture = $request->fixture_id;
        $predictionType = $request->prediction_type;

        $singleTip = $this->inHousePrediction->create([
            'fixture_id' =>  $fixture,
            'prediction_type_id' => $predictionType,
            'prediction_category_id' => 0
        ]);

        return response([
            'data' => new InHousePredictionResource($singleTip),            
            'message' => 'Single Tip created successfully'
        ], Response::HTTP_OK);
        
    }

    public function createPredictionBundle(Request $request, PredictionBundleRepository $predictionBundles, BundleItemRepository $bundleItems){
        
        $this->validate($request,[
            'expires_at' => ['required','date',"after_or_equal:".Carbon::today()],
            'predictions' => ['required', 'array','min:2'],
            'predictions.*' => ['distinct'],
            'predictions.*.fixture_id' => ['required', 'integer', new CheckIfFixtureExists],
            'predictions.*.prediction_type' => ['required', 'integer', new CheckIfPredictionTypeExists],
            
        ]);
        $expires_at = $request->expires_at;
        $predictions = $request->predictions;
        //get Bundle Id
        $matches =  count($predictions);
        $bundleId = $this->category->createOrGetBundleId($matches);
        //Create Bundle 

        $bundle = $predictionBundles->create([
            'prediction_category_id' => $bundleId,
            'expires_at' => $expires_at
        ]);

        $bundle ? $bundleItems->createBundleItems($predictions, $bundle->id): new Exception("Unable to create Bundle");                     

        return response([
            
            'message' => 'Prediction Bundle created successfully'
        ], Response::HTTP_OK);
        
        
        

        
    }

    public function updatePredictionBundle($bundleId,Request $request,PredictionBundleRepository $predictionBundles, BundleItemRepository $bundleItems){
        $this->validate($request,[
            // 'expires_at' => ['required','date',"after_or_equal:".Carbon::today()],
            'predictions' => ['required', 'array','min:2', new CheckNoOfMatchesInBundle($bundleId)],
            'predictions.*' => ['distinct'],
            'predictions.*.fixture_id' => ['required', 'integer', new CheckIfFixtureExists],
            'predictions.*.prediction_type' => ['required', 'integer', new CheckIfPredictionTypeExists],
            
        ]);
       

    }

    public function getPredictionBundle($bundleId,PredictionBundleRepository $predictionBundles, BundleItemRepository $bundleItems){
        $predictionBundle = $predictionBundles->findWhereFirst([
            'id' => $bundleId
        ]);        

        return new PredicitionBundleResource($predictionBundle);
    }



}
