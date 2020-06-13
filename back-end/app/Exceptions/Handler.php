<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }


    public function render($request, \Throwable $exception)
    {
        $class = get_class($exception);
        switch($class) {
            case AuthorizationException::class: return rs(401, __('user.unauthorized'));
            case ModelNotFoundException::class:
            case NotFoundHttpException::class: return rs(404, __('msg.notfound'));
            case FormValidateException::class: return rs($exception->getCode(), $exception->getMessage());
            case ValidationException::class: return rs(400, head(head(array_values($exception->errors()))));
        }
        if(in_array($exception->getCode(), [401, 403], true)) {
            return rs($exception->getCode(), $exception->getMessage());
        }
        $code = (int) ($exception instanceof HttpException ? $exception->getStatusCode() : $exception->getCode());
        $code === 0 && $code = 500;

        return rs($code, $exception->getMessage(), $exception->getTrace());
    }

}
















