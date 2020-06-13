<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index() {
        $builder = Tag::query()->with('user');
        $this->mSearch($builder);
        isset($this->search['creator']) && $builder->whereHas('user', function($q) {
            $q->where('name', 'like', "%{$this->search['creator']}%");
        });
        $tags = $builder->latest()->paginate($this->perPage);
        return rs($tags);
    }

    public function show($id) {
        $tag = Tag::query()->findOrFail($id);
        return rs($tag);
    }

    public function store() {
        $tag = new Tag;
        $tag->name = request('name');
        $tag->click = 0;
        $tag->weight = request('weight');
        $tag->userId = Auth::id();
        $tag->save();
        return rs($tag);
    }

    public function update($id) {
        $tag =Tag::query()->findOrFail($id);
        $tag->name = request('name');
        $tag->weight = request('weight');
        $tag->save();
        return rs($tag);
    }

    public function destroy($id) {
        Tag::query()->findOrFail($id)->delete();
        return rs();
    }

    public function __construct(TagRequest $request) {
        parent::__construct($request);
    }
}
