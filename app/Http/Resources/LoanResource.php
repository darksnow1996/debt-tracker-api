<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'amount' => $this->amount,
            'date_collected' => $this->date_collected,
            'total_amount_paid'=> $this->total_amount_paid,
            'status' => $this->status,
            'loanee' => new LoaneeResource($this->loanee)
        ];
    }
}
