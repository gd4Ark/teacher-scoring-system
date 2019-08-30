<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];
    protected $customRender = [
        ApiException::class,
    ];

    /**
     * @param Exception $exception
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return \Illuminate\Http\Response|null
     */
    public function render($request, Exception $exception)
    {
        if ($render = $this->handleCustomRender($exception)) {
            return $render;
        }
        return parent::render($request, $exception);
    }

    /**
     * @param $exception
     * @return |null
     */
    private function handleCustomRender($exception)
    {
        foreach ($this->customRender as $key => $e) {
            if ($exception instanceof $e) {
                return $exception->render();
            }
        }
        return null;
    }
}
