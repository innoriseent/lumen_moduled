<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;
use Validator;

abstract class BaseRequestValidator
{
    protected $exception = null;
    abstract public function validate(array $properties);
}
