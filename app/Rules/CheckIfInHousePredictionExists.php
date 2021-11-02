<?php

namespace App\Rules;

use App\Models\InHousePrediction;
use App\Models\Prediction;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckIfInHousePredictionExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return InHousePrediction::where([
            'id' => $value["fixture_id"],
            
            ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The prediction Id has to be a valid prediction';
    }
}
