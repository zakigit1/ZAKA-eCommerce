<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // if the user or vendor has been banned form the website (status is inactive)
        if($request->user()->status == 'inactive'){

            Auth::guard('web')->logout();
            $request->session()->regenerateToken();

            toastr('Account Has Been Banned From Website. Please Contact The Support !','error','Account Banned!');
            return redirect('/');
        }

        


        // if($request->user()->role ==='admin'){

        //     ## The same methods
        //     // return redirect()->route('admin.dashboard');
        //     return redirect()->intended(RouteServiceProvider::HOME_ADMIN);

        // }elseif($request->user()->role ==='vendor'){

        //     // return redirect()->route('vendor.dashboard');
        //     return redirect()->intended(RouteServiceProvider::HOME_VENDOR);

        // }
        
        ## For user
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function changeViewList(Request $request){
        Session::put('auth_view_list',$request->style);
    }
}
