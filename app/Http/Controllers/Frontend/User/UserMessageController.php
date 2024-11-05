<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserMessageController extends Controller
{
    public function index() :View
    {
        return view('Frontend.user.Dashboard.messanger.index');
    }
}
