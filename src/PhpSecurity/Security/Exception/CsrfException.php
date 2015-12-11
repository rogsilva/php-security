<?php

namespace PhpSecurity\Security\Exception;


class CsrfException extends \Exception
{
    public function __construct($message)
    {
        $this->message = $message;
    }
} 