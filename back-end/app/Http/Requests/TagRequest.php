<?php

namespace App\Http\Requests;

use App\Models\Tag;

class TagRequest extends FormRequest
{
    public function rules() {
        $id = request('id');
        $action = request()->route()->action['as'];
        $tagTable = (new Tag)->getTable();
        $rule = [
            'tag.store' => [
                'name' => "required|max:20|unique:$tagTable",
                'weight' => 'required|integer|between:0,1000000',
            ],
            'tag.update' => [
                'name' => "required|max:20|unique:$tagTable,name,$id",
                'weight' => 'required|integer|between:0,1000000',
            ],
        ];
        return $rule[$action] ?? [];
    }
}
