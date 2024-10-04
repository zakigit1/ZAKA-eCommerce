<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\NewsletterSubscribersDataTable;
use App\Http\Controllers\Controller;
use App\Mail\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function index(NewsletterSubscribersDataTable $dataTable){
        return $dataTable->render('admin.subscriber.index');
    }

    public function destroy(string $id){

        $subscriber = NewsletterSubscriber::find($id);

        if(!$subscriber){
            toastr('Subsciber Not Found','error','Error');
            return redirect()->route('admin.subscriber.index');
        }

        $subscriber->delete();
        return response(['status'=>'success','message'=>"Subscriber Is Deleted Successfully !"]);
        
    }


    public function sendMail(Request $request){
        // dd($request->all());

        $request->validate([
            'subject'=>'required',
            'message'=>'required'
        ]);

        $emails_verified = NewsletterSubscriber::where('is_verified' , 1)->pluck('email')->toArray();

        // i need to change this method of sending mail to a queue method for best optimazation
        Mail::to($emails_verified)->send(new Newsletter($request->subject , $request->message));


        toastr("Mail Is Sent Successfully !",'success','Success');
        return redirect()->back();

    }
}
