<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GlobalRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        switch ($user->user_role) {
            case 'admin':
                $request->merge(['user_data' => $user]);
                break;

            case 'reviewer':
                // $user->load('reviewer');
                $request->merge(['user_data' => $user, 'reviewer_data' => $user->reviewer]);
                break;

            case 'dosen':
                // $user->load('dosen');
                if ($user->dosen_role == 'kaprodi') {
                    // $user->dosen->load('prodi');
                    $request->merge(['user_data' => $user, 'dosen_data' => $user->dosen, 'prodi_data' => $user->kaprodi]);
                } elseif ($user->dosen_role == 'dekan') {
                    // $user->dosen->load('fakultas');
                    $request->merge(['user_data' => $user, 'dosen_data' => $user->dosen, 'fakultas_data' => $user->dekan]);
                } else {
                    $request->merge(['user_data' => $user, 'dosen_data' => $user->dosen]);
                }
                break;
        }

        return $next($request);
    }
}
