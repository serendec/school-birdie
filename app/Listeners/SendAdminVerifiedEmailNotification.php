<?php

namespace App\Listeners;

use App\Mail\NewUserVerifiedNoticeMail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAdminVerifiedEmailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * 
     * @param Verified $event
     * @return void
     */
    public function handle(Verified $event): void
    {
        Mail::to($event->user->school->email)->send(new NewUserVerifiedNoticeMail($event->user));
    }
}
