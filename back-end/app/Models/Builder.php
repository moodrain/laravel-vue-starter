<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Builder as LaravelBuilder;
use Illuminate\Support\Str;

class Builder extends LaravelBuilder {

    public function search($queries, $rules = []) {
        ! $rules && $rules = $this->model->searchRule;
        foreach($rules as $name => $type) {
            if(isset($queries[$name])) {
                $value =  $queries[$name];
                if(in_array($type, ['=', '>', '<', '>=', '<=', '<>', '!='])) {
                    $this->where(Str::snake($name), $type, $queries[$name]);
                    continue;
                }
                switch($type) {
                    case 'like': $this->where(Str::snake($name), 'like', "%$value%");break;
                    case 'between': $this->whereBetween(Str::snake($name), $value);break;
                }
            }
        }
        return $this;
    }

    public function sort($sorts, $rules = []) {
        ! $rules && $rules = $this->model->sortRule;
        foreach($rules as $name) {
            if(isset($sorts[$name])) {
                $this->orderBy(Str::snake($name), (int) $sorts[$name] > 0 ? 'asc' : 'desc');
            }
        }
        return $this;
    }

}
