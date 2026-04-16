<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (empty($roles)) {
            return $next($request);
        }

        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // Optional: Redirect based on role if unauthorized
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('doctor.dashboard'),
            'pasien' => redirect()->route('patient.dashboard'),
            'apoteker' => redirect()->route('pharmacist.dashboard'),
            'kasir' => redirect()->route('cashier.dashboard'),
            default => abort(403, 'Unauthorized action.'),
        };
    }
}
