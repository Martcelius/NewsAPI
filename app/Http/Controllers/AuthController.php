<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use App\User;


class AuthController extends Controller
{
    /**
     * @api {post} /api/v1/user/register Simple register user
     * @apiVersion 0.1.0
     * @apiName userRegister
     * @apiGroup User
     * @apiPermission public
     *
     * @apiDescription Digunakan untuk register user dan akan generate token untuk akses endpoint dengan permission:auth.
     *
     * @apiExample Contoh untuk register user:
     * http://localhost:8000/api/v1/user/register
     * 
     * @apiParam {string} name nama dari user baru
     * @apiParam {string} email email dari user baru
     * @apiParam {varchar} password password dari user baru
     */

    /**
     * @api {post} /api/v1/user/signin Simple signin user
     * @apiVersion 0.1.0
     * @apiName userSignin
     * @apiGroup User
     * @apiPermission public
     *
     * @apiDescription Digunakan untuk signin user dan akan generate token untuk akses endpoint dengan permission:auth.
     *
     * @apiExample Contoh untuk signin user:
     * http://localhost:8000/api/v1/user/signin
     * 
     * @apiParam {string} email email dari user 
     * @apiParam {varchar} password password dari user 
     */

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
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
            'password' => 'required'
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
