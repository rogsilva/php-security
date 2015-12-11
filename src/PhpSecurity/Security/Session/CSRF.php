<?php

namespace PhpSecurity\Security\Session;

use PhpSecurity\Security\Exception\CsrfException;
use PhpSecurity\Security\Exception\CsrfExpireTimeException;
use PhpSecurity\Security\Exception\CsrfInvalidExpireTimeException;

class CSRF
{

    private static $csrfTokenName = "php_security_token";
    private static  $csrfExpireTime = 7200;
    private static $csrfToken = null;


    public function __construct($csrfTokenName = null, $csrfExpireTime = null)
    {
            if(!is_null($csrfTokenName))
                    self::$csrfTokenName = $csrfTokenName;

            if(!is_null($csrfExpireTime))
                    self::$csrfExpireTime = $csrfExpireTime;

            if(!$_SESSION)
                    session_start();

            if(is_null(self::$csrfToken))
                    $this->tokenGenerate();

    }


    public function setCsrfTokenName($tokenName)
    {
            if(isset($_SESSION[self::$csrfTokenName]))
                    unset($_SESSION[self::$csrfTokenName]);

            self::$csrfTokenName = $tokenName;
            return $this;
    }


    public function getCsrfTokenName()
    {
            return self::$csrfTokenName;
    }


    public function setCsrfExpireTime($time)
    {
            if(!is_integer($time) || is_null($time))
                    throw new CsrfInvalidExpireTimeException($time);

            self::$csrfExpireTime = $time;
            return $this;
    }


    public function getCsrfToken()
    {
            if(time() - $_SESSION[self::$csrfTokenName]['time'] > self::$csrfExpireTime)
                    $this->tokenGenerate();

            return self::$csrfToken;
    }


    public function csrfCheck()
    {
            if(time() - $_SESSION[self::$csrfTokenName]['time'] > self::$csrfExpireTime)
                    throw new CsrfExpireTimeException();

            if(!$this->isValidToken())
                    throw new CsrfException("The token is invalid!");

            return true;
    }


    private function isValidToken()
    {
            if(!isset($_POST[self::$csrfTokenName]))
                    return false;

            return $_POST[self::$csrfTokenName] == $_SESSION[self::$csrfTokenName]['token'];
    }


    private function tokenGenerate()
    {
            self::$csrfToken = sha1($_SERVER['REMOTE_ADDR'] . time());
            $_SESSION[self::$csrfTokenName] = ['token' => self::$csrfToken, 'time' => time()];
    }


} 