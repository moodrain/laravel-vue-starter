<?php

namespace App\Http\Requests;

use App\Exceptions\FormValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class FormRequest extends LaravelFormRequest
{
    public function failedValidation(Validator $validator) {
        throw new FormValidateException($validator->errors()->first(), 400);
    }

    public function action() {
        return request()->route()->action['as'] ?? null;
    }

    public function id() {
        if(request('id')) {
            return request('id');
        }
        $pathArr = explode('/', request()->path());
        return (int) $pathArr[count($pathArr) - 1];
    }

    public function defaults() {
        return [];
    }

    public function initDefault() {
        $defaults = $this->defaults();
        foreach($defaults as $action => $keyVal) {
            if($this->action() == $action) {
                foreach($keyVal as $key => $val) {
                    ! request()->filled($key) && request()->offsetSet($key, $val);
                }
                break;
            }
        }
    }

    public function rules() {
        return [];
    }

}
