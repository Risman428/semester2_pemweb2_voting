<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class VerifyIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role_id = $request->user()->role_id;
        $adminId = Role::where('role_name', 'admin')->first()->id;

        if($role_id != $adminId)
        {
            Alert::error('Gagal', 'Anda tidak memiliki akses ke halaman ini');
            return redirect()->route('home');
        }


        return $next($request);
    }
}
