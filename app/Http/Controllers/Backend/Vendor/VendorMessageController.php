<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VendorMessageController extends Controller
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
        return view('vendor.messanger.index',compact('clientsInfo'));
    }


    public function getConversion(Request $request){       
        
        $request->validate([
            'receiverId' => 'required|exists:chats,receiver_id|gt:0',
        ]);
        // dd($request->all());

        try{
            $senderId = Auth::user()->id;
            $receiverId = $request->receiverId;

            $messages = Chat::whereIn('receiver_id', [$senderId, $receiverId])
                ->whereIn('sender_id', [$receiverId, $senderId])
                ->orderBy('created_at', 'asc')
                ->get();
    
            return response()->json(['status' => 'success','conversion' => $messages]);
        }catch(\Exception $e){
            return response()->json(['status'=> 'error','message' => $e->getMessage()]);
        }
    } 

    // Seller send message to customer 
    public function sellerMessage(Request $request){
       
       
        $request->validate([
            'receiver_id' => 'required|exists:users,id|gt:0',//is the user id how created the product
            'message' => 'required',
        ]);
        
        // dd($request->all());

        if(Auth::user()->id == $request->receiver_id){
            toastr('You cannot send message to yourself','error','Error');
            return redirect()->back();
        }

        $chat = New Chat();
        $chat->sender_id = Auth::user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->save();

        // send message in conversion (realtime)
        broadcast(new MessageEvent(
            $chat->message,
            $chat->receiver_id,
            $chat->created_at
        ));
        

        return response()->json(['status' => 'success','message' => 'Message sent successfully']);
        
    }
}
