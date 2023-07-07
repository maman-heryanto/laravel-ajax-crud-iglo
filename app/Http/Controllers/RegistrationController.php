<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function index()
    {
        $data['title'] = 'Registration';
        return view('Registration', $data);
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {
            //validatate email yet
            $cek_email = User::where('email', "$request->email")
                ->get();

            if (count(($cek_email)) > 0) {
                return response()->json([
                    'status' => 202,
                    'success' => false,
                    'message' => "email has been registered, please check again"
                ], 200);
            }

            $data_insert = array(
                'id' => Str::uuid(),
                'email' => $request->email,
                'password' => Hash::make($request->password)
            );
            $user = new User($data_insert);
            $user->save();
            DB::commit();

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => "Registration Success",
                'data' => $request->all(),
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ], 200);
        }
    }
}