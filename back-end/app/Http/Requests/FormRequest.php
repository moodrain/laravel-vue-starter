<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class FormRequest extends LaravelFormRequest
{
    public function failedValidation(Validator $validator) {
        throw new \Exception($validator->errors()->first(), 400);
    }
}
