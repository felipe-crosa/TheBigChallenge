<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_resend_email_verification()
    {
        Notification::fake();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->postJson('api/email/verification-notification');
        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
