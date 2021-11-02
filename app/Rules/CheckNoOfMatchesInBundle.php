<?php

namespace App\Rules;

use App\Models\Prediction;
use App\Models\PredictionBundle;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckNoOfMatchesInBundle implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

     private $bundleID;
    public function __construct($bundleID)
    {
        $this->bundleID = $bundleID;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $category =  PredictionBundle::where('id', $this->bundleID)
        ->first()
        ->category
        ->matches;
        return count($value) === $category;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The no of matches has to match the bundle';
    }
}
