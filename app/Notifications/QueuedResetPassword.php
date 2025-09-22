<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;

class QueuedResetPassword extends BaseResetPassword implements ShouldQueue
{
    // 直接繼承官方的 ResetPassword，只是加上 ShouldQueue
}