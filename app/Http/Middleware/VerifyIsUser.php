<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class VerifyIsUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role_id = $request->user()->role_id;
        $userRole = Role::where('role_name', 'user')->first();

        if (!$userRole || $role_id != $userRole->id) {
            Alert::error('Gagal', 'Hanya user biasa yang bisa voting');
            return redirect()->route('home');
        }

        return $next($request);
    }
}
