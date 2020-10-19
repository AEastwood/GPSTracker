<?php

namespace App\Exceptions;

use Exception;

class AccountLimitException extends Exception
{
    public $message;
    public $status = 403;

    public function __construct($m = null) {
        $this->message = $m;
    }
}
