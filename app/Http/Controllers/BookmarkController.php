<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookmarkCollection;
use App\Repositories\BookmarkRepository;
use App\Rules\CheckIfPredictionExists;
use App\Rules\CheckIfPredictionInBookmark;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BookmarkController extends Controller
{


    public $bookmarks;
    public function __construct(BookmarkRepository $bookmarks)
    {
        $this->bookmarks = $bookmarks;
    }
    

    public function getUserBookmarks(){
       // dd("text");
        $bookmarks = $this->bookmarks->getUserBookmarks();
        return new BookmarkCollection($bookmarks);
    }


    public function addToBookmark(Request $request){
        try{
            $this->validate($request, [
                'prediction_id' => ['integer','required', new CheckIfPredictionExists, new CheckIfPredictionInBookmark]
            ]);
            $prediction = $request->prediction_id;
        $bookmarks = $request->user()->bookmarks()->create([
            'prediction_id' => $prediction
        ]);
        return response([
            'message' => 'Added to Bookmark successfully'
        ], Response::HTTP_OK);

        }
        catch(ValidationException $e){
            return response([
                'message' => "The given data is invalid",
                'errors' => $e->errors()
                
            ],Response::HTTP_NOT_ACCEPTABLE);

        }
       
    }
}
