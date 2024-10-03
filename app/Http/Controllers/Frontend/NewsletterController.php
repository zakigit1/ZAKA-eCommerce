<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\SubscriptionVerification;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function newLetterRequest(Request $request){

        $request->validate([
            'email'=>'required|email',
        ]);

        // return $request->all();

       
        $subscriberExists = NewsletterSubscriber::where('email', $request->email)->first();

        if(!empty($subscriberExists) && count($subscriberExists) > 0){

            if($subscriberExists->is_verified == 0){
                // send verification link here
            }elseif($subscriberExists->is_verified == 1){
                return response(['status'=>'error' ,'message'=>'You Already Subscriber With This Email !']);
            }


        }else{

            $newSubscriber = new NewsletterSubscriber();

            $newSubscriber->email = $request->email;
            $newSubscriber->verified_token = Str::random(25);
            $newSubscriber->is_verified = 0;
            $newSubscriber->save() ;

            //mail configuration 
            MailHelper::setMailConfig();

            //send mail :

            Mail::to($newSubscriber->email)->send(new SubscriptionVerification($newSubscriber));

            return response(['status' => 'success' , 'message' => 'A Verification Link Has Been Sent To Your Email Please Check']);

        }

    }



    public function newLetterEmailVerify(string $token){

        dd($token);

    }
}
