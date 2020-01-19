<?php

namespace App\Models;

class Tag extends Model
{

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public $searchRule = [
        'id' => '=',
        'name' => 'like',
        'createdAt' => 'between',
    ];

    public $sortRule = ['id', 'click', 'weight', 'createdAt', 'updatedAt'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
