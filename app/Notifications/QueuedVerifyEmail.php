<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

class QueuedVerifyEmail extends BaseVerifyEmail implements ShouldQueue
{
    // 不需要額外寫任何方法
    // 繼承原本 VerifyEmail 的所有功能 (簽章 URL, 到期時間, route 等等)
    // 唯一差別：因為 implements ShouldQueue，會透過 Queue 發送
}