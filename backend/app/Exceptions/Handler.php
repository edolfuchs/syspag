<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\Utilidade;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
   * Report or log an exception.
   *
   * @param  \Throwable  $exception
   * @return void
   *
   * @throws \Throwable
   */
  public function report(Throwable $exception)
  {
    parent::report($exception);
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Throwable  $exception
   * @return \Symfony\Component\HttpFoundation\Response
   *
   * @throws \Throwable
   */
  public function render($request, Throwable $exception)
  {
    $exception = $this->prepareException($exception);

    $status = 500;
    $error = [
      'msg' => null,
      'options' => [],
      'trace' => []
    ];

    switch (get_class($exception)) {

      case 'App\Exceptions\CustomException':
        $status = $exception->getCode();
        $error['options'] = $exception->getOptions();
        $error['msg'] =  $exception->getMessage();
        break;

      default:
        $error['msg'] =  $exception->getMessage();
        break;
    }

    if (config('app.debug')) {
      $error['trace'] = [
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'info' => $exception->getTrace()
      ];
    }

    return Utilidade::toJson($error, $status);
  }
}
