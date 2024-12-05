<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\NewsletterSubscribersDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\SubscriberMailJob;
use App\Mail\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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


        try {

            $request->validate([
                'subject'=>'required',
                'message'=>'required'
            ]);
    
            $emails_verified = NewsletterSubscriber::where('is_verified' , 1)->pluck('email')->toArray();
    
            // i need to change this method of sending mail to a queue method for best optimazation
            Mail::to($emails_verified)->send(new Newsletter($request->subject , $request->message));
    
            /** using queue and job (it is not working i need to search where is the issue) */
            // $this->send_mail_to_subscriber($request->subject , $request->message);
    
            toastr('Mail has been sent successfully to subscribers !','success','Success');
            return redirect()->back();

        } catch (ValidationException $e) {
            toastr($e->getMessage(),'error','Error');
            return redirect()->back();
        } catch (\Exception $ex) {
            toastr($ex->getMessage(),'error');
            return redirect()->back();
        }
    }



    public function send_mail_to_subscriber($subject, $message)
    {
        NewsletterSubscriber::chunk(2, function($subscribers) use ($subject, $message) {
            dispatch(new SubscriberMailJob($subscribers,$subject,$message));
        });
    }









}
