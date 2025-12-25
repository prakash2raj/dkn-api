<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            'region' => 'nullable',
            'role_id' => 'nullable|exists:roles,id',
            'office_id' => 'nullable|exists:offices,id',
        ]);

        $data['password'] = bcrypt($data['password']);

        if (empty($data['role_id'])) {
            $roleModel = \App\Models\Role::where('role_name', $data['role'])->first();
            if ($roleModel) {
                $data['role_id'] = $roleModel->id;
            }
        }

        $user = User::create($data);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('dkn-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
