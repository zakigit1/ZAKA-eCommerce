<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;

use App\Mail\Contact;
use App\Mail\ContactSupport;
use App\Models\About;
use App\Models\EmailConfiguration;
use App\Models\TermAndCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function aboutIndex(){
        $about = About::first();
        return view('Frontend.store.pages.about',compact('about'));
    }

    public function termsAndConditionsIndex(){
        $termsAndConditions = TermAndCondition::first();
        return view('Frontend.store.pages.terms-and-conditions',compact('termsAndConditions'));
    }






    public function index(){

        return view('Frontend.store.pages.contact');
    }



    public function handleContactForm(Request $request){
       

        $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|email',
            'subject' => 'required|max:200',
            'message' => 'required|max:1000',
        ]);

        // dd($request->all());

        try{

  

            //this is the email official of the website . for support
            $EmailOfficial = EmailConfiguration::first()->email;
            
            //Send Mail to our support
            Mail::to($EmailOfficial)->send(new Contact($request->subject ,$request->message,$request->email));
        
            // Mail::to($EmailOfficial)->send(new ContactSupport($request->subject ,$request->message,$request->email));

        
        
            return response(['status' => 'success','message' => 'Mail sent successfully!']);

        }catch(\Exception $ex){
        
            return response(['status' => 'error','message' => $ex->getMessage()]);
        }



    }
}
