<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Dapatkan peran pengguna yang sedang login
        $user = Auth::user();
        // Periksa apakah pengguna memiliki salah satu dari peran yang diizinkan
        if (!in_array($user->user_role, $roles)) {
            // Jika tidak, redirect atau kembalikan response dengan pesan error
            // return response()->json(['message' => 'You do not have permission to access this page.'], 403);
            // return view('error.403');
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}
