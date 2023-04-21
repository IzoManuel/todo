<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\UserLoginRequest;
use Modules\Auth\Http\Requests\UserRegisterRequest;
use Modules\User\Entities\User;

class AuthController extends BaseController
{

    /**
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function Login(UserLoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['email'] = $authUser->email;

            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Wrong Email and Password commbination', [
                    'email' => ['Wrong Email and Password commbination'],
            ], 401);
        }
    }

    /**
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $success['token'] = $user->createToken('MyTodoApp')->plainTextToken;
        $success['email'] = $user->email;

        return $this->sendResponse($success, 'User registered');
    }

    /**
     * Logout user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->sendResponse('User logged out');
    }
}
