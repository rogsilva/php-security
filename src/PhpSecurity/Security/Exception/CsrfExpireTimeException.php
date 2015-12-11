<?php

namespace PhpSecurity\Security\Exception;


class CsrfExpireTimeException extends CsrfException
{
    public function __construct()
    {
        $this->setMessage();
    }

    private function setMessage()
    {
        $this->message = "The session time expired!";
    }
} 