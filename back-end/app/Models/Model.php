<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Model extends LaravelModel
{
    use SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    protected $hidden = ['deleted_at'];
    protected $guarded = ['id'];

    public $searchRule = ['id' => '='];
    public $sortRule = ['id', 'createdAt', 'updatedAt'];

    public static $snakeAttributes = false;

    public function getAttribute($key) {
        return parent::getAttribute(Str::snake($key));
    }

    public function setAttribute($key, $value) {
        return parent::setAttribute(Str::snake($key), $value);
    }

    public function attributesToArray() {
        $array = parent::attributesToArray();
        $new = [];
        foreach($array as $key => $value) {
            $new[Str::camel($key)] = $value;
        }
        return $new;
    }

    public function relationsToArray() {
        $relations = parent::relationsToArray();
        $new = [];
        foreach($relations as $relation => $attribute) {
            if(is_array($attribute)) {
                $new[$relation] = [];
                foreach($attribute as $key => $value) {
                    $new[$relation][Str::camel($key)] = $value;
                }
            } else {
                $new[$relation] = $attribute;
            }
        }
        return $new;
    }

    public function newEloquentBuilder($query) {
        return new Builder($query);
    }

}
