<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            
            
        });

        
    }


    public function render($request, Throwable $e)
    {
        if($e instanceof ModelNotDefinedException){
            return response()->json([
                'message' => 'Model Not Defined'
            ], 500);
        }

        if ($e instanceof ModelNotFoundException)
    {
        return response()->json([
            'message' => 'Resource not found'
        ], 404);


    }

    if ($e instanceof ValidationException
   )
{
    return response()->json([
        'message' => "The data provided is invalid",
        'errors' => $e->errors()
    ], 406);


}

    
    return response()->json([
        'message' => $e->getMessage()
    ],500);

      //  return parent::render($request,$e);
    }
}
