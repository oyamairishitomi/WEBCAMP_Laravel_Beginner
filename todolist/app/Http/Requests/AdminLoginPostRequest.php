<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginPostRequest extends FormRequest
{
    public function rules(): array{
        return [
            'login_id' => ['required', 'max: 255'],
            'password' => ['required', 'max:72'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

}
