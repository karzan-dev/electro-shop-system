<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Role parameter: 'admin', 'casher', or 'admin,casher'
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'تکایە یەکەم جار بچێتە ژوورەوە');
        }

        // Get user role
        $userRole = Auth::user()->role;

        // Define role mapping
        $roleMap = [
            'admin' => 2,
            'casher' => 1,
        ];

        // Convert role names to numeric values
        $allowedRoles = [];
        foreach ($roles as $role) {
            if (isset($roleMap[$role])) {
                $allowedRoles[] = $roleMap[$role];
            }
        }

        // Check if user role is allowed
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'تۆ ڕێگەپێدراوی نییت بۆ چوونە ناو ئەم پەڕەیە');
        }

        return $next($request);
    }
}
