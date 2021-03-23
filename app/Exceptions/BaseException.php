<?php


namespace App\Exceptions;


use Throwable;

class BaseException extends \Exception
{
    protected $container = null;

    public function __construct($container = null, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->container = $container;
        parent::__construct($message, $code, $previous);
    }

    public function returnContainer(){
        return $this->container;
    }
}
