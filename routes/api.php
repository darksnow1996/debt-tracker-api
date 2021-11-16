<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\NewPasswordController;
use App\Http\Controllers\auth\PasswordResetLinkController;

use App\Http\Controllers\User\MeController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoaneeController;
use App\Http\Controllers\PredictionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([],function(){
    
    
    Route::post('tests', [SettingsController::class, 'test']);
    //Prediction Routes
    
    // Route::get('predictions/in-house', [PredictionsController::class, 'getInHousePredictions']);

    //IN HOUSE PREDICTIONS
    
   

    //Fixture Routes
    

    //League Routes
   

    //contact
    Route::post('contacts/create',[ContactController::class, 'create']);
    


    //Team Routes

    

Route::group(['middleware'=> 'guest'],function(){
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('password/email', [PasswordResetLinkController::class, 'store'])->name('password.request');
    Route::post('password/reset/{token}', [NewPasswordController::class, 'store'])->name('password.reset');
        
});





Route::group(['middleware'=> ['auth:sanctum',]], function(){
    Route::get('me',[MeController::class, 'getMe']);

    Route::post('logout',[AuthController::class, 'logout']);
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend'); // Make sure to keep this as your route name

    //User Profile Settings
    Route::post('settings/profile',[SettingsController::class, 'updateProfile']);
    Route::post('settings/password',[SettingsController::class, 'updatePassword']);

    //Loanees
    Route::get('loanees',[LoaneeController::class, 'getLoanees']);
    Route::get('loanees/{id}',[LoaneeController::class, 'getLoanee']);
    Route::post('loanees',[LoaneeController::class, 'createLoanee']);
    Route::post('loanees/{id}',[LoaneeController::class, 'updateLoanee']);



     //Loans
     Route::get('loans',[LoanController::class, 'getLoans']);
     Route::get('loans/{id}',[LoanController::class, 'getLoan']);
     Route::post('loans',[LoanController::class, 'createLoan']);
     Route::post('loans/{id}',[LoanController::class, 'updateLoan']);


     Route::get('dashboard',[DashboardController::class, 'getDashboardData']);



    // //Bookmarks
    // Route::get('bookmarks',[BookmarkController::class, 'getUserBookmarks']);
    // Route::post('bookmarks/add',[BookmarkController::class, 'addToBookmark']);



    // //PREDICTION TYPES
    // Route::get('predictions/types',[PredictionsController::class, 'getPredictionTypes']);
    // Route::post('predictions/types/',[PredictionsController::class, 'createPredictionType']);
    // Route::get('predictions/types/{predictionType}',[PredictionsController::class, 'createPredictionType']);
    // Route::post('predictions/types/{predictionType}',[PredictionsController::class, 'createPredictionType']);
    

    // //PREDICTION BUNDLES
    // Route::get('predictions/bundles/types',[PredictionsController::class, 'getPredictionCategories']);
    // Route::post('predictions/bundles/types',[PredictionsController::class, 'createPredictionCategory']);


    //  //IN HOUSE PREDICTIONS
    //  Route::post('predictions/bundles',[PredictionsController::class, 'createPredictionBundle']);
    //  Route::get('predictions/bundles/{BUNDLE_ID}',[PredictionsController::class, 'getPredictionBundle']);
    //  Route::post('predictions/bundles/{BUNDLE_ID}',[PredictionsController::class, 'updatePredictionBundle']);
    //  Route::post('predictions/single',[PredictionsController::class, 'createSingleTip']);


    //  //Blog Artiucles
    //  Route::get('articles/',[PredictionsController::class, 'createPrediction']);
    //  Route::post('articles/',[PredictionsController::class, 'createPrediction']);
    //  Route::get('articles/{article}',[PredictionsController::class, 'createPrediction']);
    //  Route::post('articles/{article}',[PredictionsController::class, 'createPrediction']);

   

    Route::group(['middleware'=> ['verified']], function(){
        
        Route::get('auth/status', [AuthController::class, 'checkAuthStatus']);

        

    });
    
    
    
    
      


});

Route::any('{any}', function(){
    return response()->json([
        'message'   => 'Endpoint does not exist',
    ], 404);
})->where('any', '.*');


});

