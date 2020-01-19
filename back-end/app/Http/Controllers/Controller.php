<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $page;
    protected $perPage;
    protected $search;
    protected $sort;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $this->page = (int) request('page', 1);
        $this->perPage = (int) request('perPage') ?? config('view.perPage');
        $this->perPage = $this->perPage > config('view.maxPerPage') ? config('view.maxPerPage') : $this->perPage;
        $this->initSearch();
        $this->initSort();
    }

    private function initSearch() {
        $search = (array) request('search');
        foreach($search as $key => $value) {
            if($value === null || $value === '') {
                unset($search[$key]);
            }
        }
        $this->search = $search;
    }

    private function initSort() {
        $sort = (array) request('sort');
        foreach($sort as $key => $value) {
            if($value === null || $value === '') {
                unset($sort[$key]);
            }
        }
        $this->sort = $sort;
    }

    protected function mSearch($builder) {
        return $builder->search($this->search)->sort($this->sort);
    }

}
