<?php


function rs(...$params) {
    header('Content-Type: application/json');
    $code = 0;
    $msg = '';
    $data = [];
    $isLaravelPaginator = isset($params[0]) && is_object($params[0]) && get_class($params[0]) == 'Illuminate\Pagination\LengthAwarePaginator';
    foreach($params as $param) {
        if(is_int($param)) {
            $code = $param;
        } else if(is_string($param)) {
            $msg = $param;
        } else if(is_array($param) || is_object($param)) {
            $data = $param;
        }
    }
    if($isLaravelPaginator) {
        $pager = $params[0];
        $data = [
            'page' => $pager->currentPage(),
            'perPage' => $pager->perPage(),
            'total' => $pager->total(),
            'data' => $pager->items(),
        ];
    }
    return response()->json([
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    ]);
}
