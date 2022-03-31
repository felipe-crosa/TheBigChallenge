<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogOutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_succesfully_logs_out()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }
}
