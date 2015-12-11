<?php

namespace PhpSecurity\Security\Exception;


class CsrfInvalidExpireTimeException extends CsrfException
{
    public function __construct($value)
    {
        $this->setMessage($value);
    }

    private function setMessage($value)
    {
        $this->message = "This Expire Time '{$value}' is an invalid argument!";
    }
} 