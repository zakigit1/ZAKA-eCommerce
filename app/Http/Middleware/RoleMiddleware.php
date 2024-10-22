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
    public function handle(Request $request, Closure $next , $role): Response
    {
        if($request->user()->role !== $role){
            /* explain this if : 
                    -$request->user()->role => mean the authenticated user role 
                    -$role => example :[role:user] ,in the routes file in the middlaware you choose it 
            */
                
            ## M1 : i do it 
            $_role= $request->user()->role;
            return redirect()->route("$_role.dashboard");

            ##M2 : 

            // if($request->user()->role == 'admin'){
            //     return redirect()->route("admin.dashboard");
            // }elseif($request->user()->role == 'vendor'){
            //     return redirect()->route("vendor.dashboard");
            // }elseif($request->user()->role == 'user'){
            //     return redirect()->route("user.dashboard");
            // }
               
        }

        return $next($request);
    }
}
