<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'referral_code' => $this->referral_code,
            'matrix_level' => $this->matrix_level,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
        ];
    }
}