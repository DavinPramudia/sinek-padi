<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPetugas
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!$user || (int) $user->id_roles !== 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak! Anda bukan Petugas.');
        }

        return $next($request);
    }
}