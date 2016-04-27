<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if( $e instanceof ModelNotFoundException){

            return response()->json(['status'=>'error', 'message' => ['Resource Not Found']], 404);

        } else if( $e instanceof MethodNotAllowedHttpException){

            return response()->json(['status'=>'error', 'message' => ['Method Not Allowed']], 405);

        } else if ($e instanceof HttpException && in_array($e->getStatusCode(), array(400, 401, 403, 404, 501))) {

            switch($e->getStatusCode()){
                case 400:
                    return response()->json(['status'=>'error', 'message' => 'Bad Request'], $e->getStatusCode());
                case 401:
                    return response()->json(['status'=>'error', 'message' => 'Unauthorized'], $e->getStatusCode());
                case 403:
                    return response()->json(['status'=>'error', 'message' => 'Forbidden'], $e->getStatusCode());
                case 404:
                    return response()->json(['status'=>'error', 'message' => 'Resource Not Found'], $e->getStatusCode());
                case 501:
                    return response()->json(['status'=>'error', 'message' => 'Not Implemented'], $e->getStatusCode());
            }
        }

        return parent::render($request, $e);
    }
}
