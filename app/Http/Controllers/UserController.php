<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password']
        ];
        if (Auth::attempt($credentials)) {
            $tokenData = Auth::user()->createToken(Config::get('auth.token_name'), [$request->user()->role]);
            $responseData['name'] = $request->user()->name;
            $responseData['api_message'] = 'Logged in successfully';
            $responseData['token'] = $tokenData->accessToken;
            return response()->json($responseData);
        }

        return response()->json(['error' => 'Incorrect combination of username or password'], 401);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:200',
                'email' => 'required|string|email',
                'password' => 'required|string|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $input = $request->all();
            $user = new User();
            $user->setAttribute('name', $input['name']);
            $user->setAttribute('email', $input['email']);
            $user->setAttribute('role', 'customer');
            $user->setAttribute('password', bcrypt($input['password']));
            $user->save();

            $responseData['token'] = $user->createToken(Config::get('auth.token_name'), [$user->role])->accessToken;
            $responseData['name'] = $user->name;
            $responseData['api_message'] = 'User registered successfully';
            return response()->json($responseData, 200);
        } catch (\Exception $exception) {
            Log::error(sprintf('Error while saving user %s', $exception->getMessage()));
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
