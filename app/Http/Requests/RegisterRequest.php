<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'    => 'required|string|max:255',
            'email'        => 'nullable|email|unique:users,email',
            'phone'        => 'required|string|unique:users,phone',
            'password'     => 'required|string|min:6|confirmed',
            'referral_code'=> 'required|string|exists:users,referral_code',
        ];
    }

    /**
     * Après validation, génère l'email si non fourni.
     */
    protected function passedValidation(): void
    {
        if (empty($this->email)) {
            $slug  = Str::slug($this->full_name, '.');
            $phone = preg_replace('/\D/', '', $this->phone);
            $this->merge(['email' => "{$slug}.{$phone}@gmail.com"]);
        }
    }
}
