<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // Force to application/json rendering on API calls
        if ($request->is('api*')) {
            // set Accept request header to application/json
            $request->headers->set('Accept', 'application/json');
        }

        // Default to the parent class' implementation of handler
        return parent::render($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $ex){
        if( $request->is('api/*') ) {
            return response()->json(['status' => false, 'message' => $ex->getMessage(), 'data'=> []], 401);
        }
        return redirect('/login');
    }
}
