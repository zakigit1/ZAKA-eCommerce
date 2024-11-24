<?php

namespace App\Http\Controllers\Frontend\User;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class UserMessageController extends Controller
{
    public function index(): View 
    {   
        $userId = Auth::user()->id;

        /** Vendor or seller profile */
        $sallersInfo = Chat::with('receiverProfile')->select('receiver_id')// this relation to get receiver informations
            ->where('sender_id', $userId)
            ->where('receiver_id', '!=', $userId)
            ->groupBy('receiver_id')
            ->get();

        // return $sallerInfo;
        return view('Frontend.user.Dashboard.messanger.index',compact('sallersInfo'));
    }


    public function clientMessage(Request $request){
       
       
        $request->validate([
            'receiver_id' => 'required|exists:vendors,user_id|exists:users,id|gt:0',//is the user id how created the product
            'message' => 'required',
        ]);
        // dd($request->all());
        

        if(Auth::user()->id == $request->receiver_id){
            toastr('You cannot send message to yourself','error','Error');
            return redirect()->back();
        }


        /** this for  limit the request message sending to the vendor */
        // /** Receiver : */
        // $SendermessageCount = Chat::where('sender_id',Auth::user()->id)
        //                  ->where('receiver_id',$request->receiver_id)
        //                  ->count();

        //                 //  dd($SendermessageCount);
        // /** Receiver : */
        // $VendormessageCount = Chat::where('sender_id',$request->receiver_id)
        //                  ->where('receiver_id',Auth::user()->id)
        //                  ->count();

        // if($SendermessageCount >= 5 && $VendormessageCount == 0){
        //     return response()->json(['status' => 'error','message' => 'You cannot send more messages until the vendor answers you.']);
        // }






        // /** Receiver : */
        // $SendermessageCount = Chat::where('sender_id', Auth::user()->id)
        // ->where('receiver_id', $request->receiver_id)
        // ->count();

        // /** Receiver : */
        // $VendormessageCount = Chat::where('sender_id', $request->receiver_id)
        // ->where('receiver_id', Auth::user()->id)
        // ->count();

        // $lastFiveMessages = Chat::where('sender_id', Auth::user()->id)
        // ->where('receiver_id', $request->receiver_id)
        // ->latest()
        // ->take(5)
        // ->get();

        // $vendorRepliedAfterLastFive = Chat::where('sender_id', $request->receiver_id)
        // ->where('receiver_id', Auth::user()->id)
        // ->where('created_at', '>', $lastFiveMessages->min('created_at'))
        // ->exists();

        // if ($SendermessageCount >= 5 && !$vendorRepliedAfterLastFive) {
        //     return response()->json(['status' => 'error', 'message' => 'You cannot send more messages until the vendor answers you.']);
        // }

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
}
