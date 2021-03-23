<?php

namespace App\Http\Requests;

use App\Exceptions\User\ExistingUserException;
use App\Exceptions\User\UserRegistrationException;
use Validator;

class UserRegistrationRequest extends BaseRequestValidator
{

    public function validate(array $properties){
        $validator = Validator::make($properties, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if($validator->fails()){
            $messages = $validator->errors();
            throw new UserRegistrationException($messages);
        }
        return $properties;
    }
}
