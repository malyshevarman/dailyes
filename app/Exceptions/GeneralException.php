<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class GeneralException extends Exception
{
    public $message;

    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report()
    {
        //
    }

    public function render($request)
    {
        return redirect()
            ->back()
            ->withInput($request->except('password', 'password_confirmation'))
            ->withFlashDanger($this->message);
    }
}
