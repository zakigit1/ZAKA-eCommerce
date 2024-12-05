<?php

namespace App\Jobs;

use App\Mail\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriberMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscribers;
    public $subject;
    public $message;


    /**
     * Create a new job instance.
     */
    public function __construct(NewsletterSubscriber $subscribers , $subject , $message)
    {
        $this->subscribers = $subscribers;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->subscribers as $subscriber){
            Mail::to($subscriber->email)->send(new Newsletter (
                $this->subject ,
                $this->message
            ));
        }
    }
}
