<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;
use Validator;

abstract class BaseRequestValidator
{

    abstract public function validate(array $properties);
}
