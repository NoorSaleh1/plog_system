<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    $user = Auth::user();
    $user=User::find(1);

    if (!$user || !$user->roles()->whereIn('name', $roles)->exists()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    return $next($request);
}
}
