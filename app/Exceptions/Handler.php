<?php

namespace App\Exceptions;
use App\Models\LogError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
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
        //
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
        $this->reportable(function (Throwable $exception) {
            $user = auth()->user();
            LogError::create([
                'user_Id' => $user ? $user->id :0,
                'message' => $exception->getMessage(),
                'exception' => get_class($exception),
                'line' => $exception->getline(),
                'trace' => array_map(function ($trace) {
                    unset($trace['args']);
                    return $trace;
                }, $exception->getTrace()),
                'method'=> request()->getMethod(),
                'params' => request()->all(),
                'uri' => request()->getPathInfo(),
                'user_agent' => request()->userAgent(),
                'header' => request()->headers->all(),
            ]);
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response('授權失敗', 401);
    }
}
