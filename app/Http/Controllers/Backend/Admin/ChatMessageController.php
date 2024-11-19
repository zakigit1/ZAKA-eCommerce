<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class ChatMessageController extends Controller
{
    public function index(): View 
    {   
        $userId = Auth::user()->id;

        /** Vendor or saller profile */
        $clientsInfo = Chat::with('senderProfile')->select('sender_id')// this relation to get receiver informations
            ->where('receiver_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->groupBy('sender_id')
            ->get();

        // return $sallerInfo;
        return view('admin.messanger.index',compact('clientsInfo'));
    }
}
