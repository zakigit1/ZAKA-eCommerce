<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboard extends Controller
{
    public function index(){
        
        return view('Frontend.user.Dashboard.dashboard');
    }
}
