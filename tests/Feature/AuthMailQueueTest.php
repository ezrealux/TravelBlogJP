<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\QueuedVerifyEmail;
use App\Notifications\QueuedResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class AuthMailQueueTest extends TestCase
{
    use RefreshDatabase;
    /*
    protected function setUp(): void
    {
        parent::setUp();  // 呼叫父類的 setUp() 方法來進行基礎設置
    }
    */
    public function testDatabaseConnection()
    {
        //dd(env('DB_DATABASE'));
        $pdo = DB::getPdo();
        $this->assertNotNull($pdo);  // 確保資料庫連接可用
    }

    /** @test */
    public function it_dispatches_verify_email_notification_to_queue()
    {
        //$columns = DB::select("PRAGMA table_info(users)");
        //dd($columns);  // 這會顯示 'users' 表的欄位結構

        Notification::fake();

        // 建立一個未驗證帳號
        $user = User::factory()->create(['email_verified_at' => null,]);
        $user->sendEmailVerificationNotification();

        // 驗證通知有被推進 queue
        Notification::assertSentTo(
            [$user],
            QueuedVerifyEmail::class,
            function ($notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }

    /** @test */
    public function it_dispatches_reset_password_notification_to_queue()
    {
        Notification::fake();

        $user = User::factory()->create();
        $token = app('auth.password.broker')->createToken($user);
        $user->sendPasswordResetNotification($token);

        // 驗證通知有被推進 queue
        Notification::assertSentTo(
            [$user],
            QueuedResetPassword::class,
            function ($notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }
}
