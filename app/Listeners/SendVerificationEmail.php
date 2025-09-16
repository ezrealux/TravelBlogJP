<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendVerificationEmail implements ShouldQueue
{
    public function handle(Registered $event): void
    {
        if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
