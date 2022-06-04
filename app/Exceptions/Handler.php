<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "success" => false,
                    "message" => "The token expired."
                ], 409);
            }
        });

        $this->renderable(function (NotFoundHttpException  $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "success" => false,
                    "message" => "Page not found"
                ], 404);
            }
        });

        $this->renderable(function (TooManyRequestsHttpException  $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ], 429);
            }
        });

        $this->renderable(function (Exception  $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ], 500);
            }
        });
    }
}
