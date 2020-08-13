<?php

use PHPUnit\Exception;

class QrCodeLimitExceeded extends Exception
{

    function __construct()
    {
        // throw new QrCodeLimitExceeded();
    }

    public $error = "Limit has exceeded";
    function getMessage()
    {
        return $this->error;
    }
    function getCode()
    {
    }
    function getTraceAsString()
    {
    }
    function getFile()
    {
    }
    function getTrace()
    {
    }

    function getPrevious()
    {
    }

    function __toString()
    {
    }
    function getLine()
    {
    }
}
