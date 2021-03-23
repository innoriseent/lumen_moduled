<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;

class RequestValidator
{
    static public function validate(array $request, $validator){
        $vtmp = new $validator;
        return $vtmp->validate($request);
    }
}
