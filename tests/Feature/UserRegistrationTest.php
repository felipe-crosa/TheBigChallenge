<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_registered_on_database()
    {
        $data = [
            'name' => 'Felipe',
            'email' => 'felicrosa@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', ['name' => 'Felipe', 'email' => 'felicrosa@gmail.com']);

        $response->assertJson(['status'=>200, 'message'=>'User has been added succesfully']);
    }

    public function test_user_cannot_register_without_name()
    {
        $data = [
            'email' => 'felicrosa@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The name field is required.']);
    }

    public function test_user_cannot_register_without_password()
    {
        $data = [
            'name' => 'Felipe',
            'email' => 'felicrosa@gmail.com',

        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(422);
        $response->assertJson(['message'=>'The password field is required.']);
    }

    public function test_user_cannot_register_without_password_confirmation()
    {
        $data = [
            'name' => 'Felipe',
            'email' => 'felicrosa@gmail.com',
            'password' => '12345678',
        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(422);
        $response->assertJson(['message'=>'The password confirmation does not match.']);
    }

    public function test_user_cannot_register_without_email()
    {
        $data = [
            'name' => 'Felipe',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(422);
        $response->assertJson(['message'=>'The email field is required.']);
    }
}
