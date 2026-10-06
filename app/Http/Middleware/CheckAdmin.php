<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!$user || (int) $user->id_roles !== 1) {
            return redirect()->route('petugas.loket')->with('error', 'Akses ditolak! Anda bukan Admin.');
        }

        return $next($request);
    }
}