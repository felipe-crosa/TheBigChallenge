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

        $response = $this->postJson('/api/logout');
        $response->assertStatus(200);
        $response->assertJson(['status'=>200, 'message'=>'User logged out succesfully']);
    }

    public function test_only_logged_in_users_can_access_route()
    {
        $this->postJson('/api/logout')->assertStatus(401);
    }
}
