<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        }
        
        $class = get_class($e);

        switch($class) {
            case 'Illuminate\\Http\\Exception\\HttpResponseException':
                return parent::render($request, $e);
                break;
            case 'Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException':
                $code = 'NotFound';
                $msg = 'Not Found.';
                $statusCode = 404;
                break;
            case 'Illuminate\Database\Eloquent\ModelNotFoundException':
                $code = 'ModelNotFound';
                $model = str_replace('App\\Models\\', '', $e->getModel());
                $msg = $model . ' not found.';
                $statusCode = 404;
                break;
            case 'Illuminate\Auth\Access\AuthorizationException':
                $code = 'InvalidCredentials';
                $msg = 'Credentials are invalid.';
                $statusCode = 400;
                break;
            case 'Tymon\JWTAuth\Exceptions\JWTException';
                $code = 'JWTException';
                $msg = 'There was an issue generating jwt tokens.';
                $statusCode = 400;
                break;
            case 'App\Exceptions\JWTAbsentException';
                $code = 'TokenAbsent';
                $msg = 'The token is absent.';
                $statusCode = 400;
                break;
            case 'App\Exceptions\JWTExpiredException';
                $code = 'TokenExpired';
                $msg = 'The token has expired.';
                $statusCode = 401;
                break;
            case 'App\Exceptions\JWTInvalidException';
                $code = 'InvalidToken';
                $msg = 'The token is invalid.';
                $statusCode = 401;
                break;
            case 'App\Exceptions\JWTUserNotFoundException';
                $code = 'UserNotFound';
                $msg = 'The user token does not match.';
                $statusCode = 404;
                break;
            default:
                $code = 'SystemError';
                $msg = $e->getMessage();
                $file = $e->getFile();
                $line = $e->getLine();
                $statusCode = 500;
        }

        $data = [
            'status' => 'error',
            'exception' => $class,
            'code' => $code,
            'msg' =>  $msg
        ];

        if (isset($file)) {
            $data['file'] = $file;
        }

        if (isset($line)) {
            $data['line'] = $line;
        }

        return response($data, $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
