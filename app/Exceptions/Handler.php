<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        $this->reportable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Resource not found'], 404);
            }

            return back()->with('error','Het item wat we proberen te vinden bestaat niet, probeer het later of probeer Quint lastig te vallen!');
        });
    }
}
