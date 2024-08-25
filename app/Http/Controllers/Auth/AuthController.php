<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $credential = $request->only('username', 'password');
        $messages = [
            'username.required'       => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
        ];

        $validator = Validator::make($credential, [
            'username' => 'required',
            'password' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        // return back()->withErrors(['message' => 'Akun Salah / Tidak Ditemukan!']);
        return redirect()->back()->with('error', 'Login Gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function unauthorized()
    {
        return view('error.403');
    }
}
