<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use App\User;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        if ($user->save()) {

            $token = null;

            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'msg' => 'Email or Password are incorrect'
                    ], 404);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'msg' => 'Failed to create token',
                ], 404);
            }

            $user->signin = [
                'href' => 'api/v1/user/signin',
                'method' => 'POST',
            ];
            $response = [
                'msg' => 'user registerd',
                'data' => $user,
                'token' => $token
            ];

            return response()->json($response, 201);
        } else {

            $response = [
                'msg' => "error occured"
            ];

            return response()->json($response, 404);
        };
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $email = $request->email;
        $password = $request->password;

        if ($user = User::where('email', $email)->first()) {
            $credentials = [
                'email' => $email,
                'password' => $password
            ];

            $token = null;

            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'msg' => 'Email or Password are incorrect'
                    ], 404);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'msg' => 'Failed to create token',
                ], 404);
            }

            $response = [
                'status' => 200,
                'msg' => 'User signin',
                'token' => $token
            ];
            return response()->json($response, 200);
        }

        $response = [
            'msg' => 'An error occurred'
        ];

        return response()->json($response, 404);

    }

}
