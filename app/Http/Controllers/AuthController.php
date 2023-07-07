<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended('/product');
        }
        $data['title'] = 'Log In';
        return view('login', $data);
    }

    public function loginAction(Request $request)
    {
        try {

            //cek user yet
            $data_user = User::where('email', $request->email)->first();
            if (!$data_user) {
                return response()->json([
                    'status' => 202,
                    'success' => false,
                    'message' => "Wrong username and password",
                    'data' => [],
                ], 200);
            }
            //check role
            // if ($data_user->access != "cms") {
            //     return response()->json([
            //         'status' => 202,
            //         'success' => false,
            //         'message' => "Your account does not have access",
            //         'data' => [],
            //     ], 200);
            // }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => "success",
                    'data' => ['url_redirect' => route('product')],
                ], 200);
            } else {
                return response()->json([
                    'status' => 202,
                    'success' => false,
                    'message' => "Wrong username and password",
                    'data' => [],
                ], 200);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ], 200);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}