<?php

namespace App\Rules;

use App\Models\Fixture;
use App\Models\InHousePrediction;
use App\Models\Prediction;
use App\Models\PredictionCategory;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckIfFixtureExistsInHouse implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $predictionType;
    public function __construct($predictionType)
    {
        $this->predictionType= $predictionType;
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

      //  dd($this->predictionType);
        return !InHousePrediction::where([
            'fixture_id' => $value,
            'prediction_type_id' => $this->predictionType

        ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This tip exists already';
    }
}
