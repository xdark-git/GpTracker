<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class LoginUserNotVerifiedException extends Exception
{
    public function __construct(
        string $message = "user not not verified",
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }
}
