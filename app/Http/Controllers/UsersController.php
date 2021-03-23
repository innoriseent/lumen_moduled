<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestValidator;
use App\Http\Requests\UserRegistrationRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class UsersController extends Controller
{
    public function register(Request $request, UserService $userService)
    {
        $data = RequestValidator::validate(json_decode($request->getContent(), true), UserRegistrationRequest::class);
        $userDetails = $userService->registerUser($data);
        return response(['data' => $userDetails, 'message' => 'Account created successfully!', 'status' => true]);
    }
}
