<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_log_in_succesfully()
    {
        $user = User::factory()->create([
            'password'=>'1234567',
        ]);

        $response = $this->postJson('/api/login', ['email'=>$user->email, 'password'=>'1234567']);

        $response->assertSuccessful();
        $response->assertJson(['status'=>200, 'message'=>'User logged in succesfully']);
    }
}
