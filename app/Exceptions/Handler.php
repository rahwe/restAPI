<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class Handler extends ExceptionHandler
{
    use ApiResponser;
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
      
        $this->renderable(function (HttpException $e, $request) {
            if ($request->is('api/*')) {
                if($e instanceof HttpException){
                    return $this->errorResponse($e->getMessage(), $e->getStatusCode());
                }
            }
           
        });
        
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                if($e->getPrevious() instanceof ModelNotFoundException){
                    return $this->errorResponse("Not exist model with given id.", 404);
                }
            }
         
            return $this->errorResponse("Specified URL connot be found.", 404);
        });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                if($e->getPrevious() instanceof ValidationException){
                    return $this->convertValidationExceptionToResponse($e, $request);
                }
            }
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                if($e->getPrevious() instanceof AuthenticationException){
                    return $this->unauthenticated($request,$e);
                }
            }
        });

        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->is('api/*')) {
                if($e->getPrevious() instanceof AuthenticationException){
                    return $this->errorResponse($e->getMessage(), 403);
                }
            }
        });

        
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                if($e instanceof MethodNotAllowedHttpException){
                    return $this->errorResponse('Method not allowed', 405);
                }
            }
           
        });

        $this->renderable(function (QueryException $e, $request) {
            if ($request->is('api/*')) {
                if($e instanceof QueryException){
                    $errorCode = $e->errorInfo[1];
                    if($errorCode == 1451){
                        return $this->errorResponse('Cannot remove this resource permanatly. It is related with any other resource.',409);
                    }
                    
                }
            }
           
        });

   
    }


    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        if($this->isFrontend($request)){
            return $request->ajax()? response()->json($errors, 422) : redirect()
            ->back()
            ->withInput($request->input())
            ->withErrors($errors);
        }
        return $this->errorResponse($errors, 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($this->isFrontend($request)){
            return redirect()->guest('login');
        }
        return $this->errorResponse('Unauthenticated.', 401);
    }

    private function isFrontend($request){
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }


}
