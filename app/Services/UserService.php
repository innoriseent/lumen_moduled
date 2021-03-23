<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function registerUser(array $data){
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        /**Take note of this: Your user authentication access token is generated here **/
        $data['token'] =  $user->createToken('Foxtools')->accessToken;
        $data['name'] =  $user->name;
        return $data;
    }

}
