<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' => $this->type,
            'amount' => $this->amount,
            'reference' => $this->reference,
            'created_at' => $this->created_at
        ];
    }
}