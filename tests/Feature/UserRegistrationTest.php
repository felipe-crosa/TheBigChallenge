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

    public function test_password_is_encrypted_in_database()
    {
        $data = [
            'name' => 'Felipe',
            'email' => 'felicrosa@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        $this->postJson('/api/register', $data);

        $this->assertDatabaseMissing('users', ['password'=>'12345678']);
    }

    /**
     * @dataProvider  invalidUserDataProvider
     */
    public function test_user_cant_register_with_invalid_data($user)
    {
        $response = $this->postJson('/api/register', $user);
        $response->assertStatus(422);
    }

    public function invalidUserDataProvider(): array
    {
        return [
            ['no Name'=>[
                'email' => 'felicrosa@gmail.com',
                'password' => '12345678',
                'password_confirmation' => '12345678',
            ]],
            ['no Password'=>[
                'name' => 'Felipe',
                'email' => 'felicrosa@gmail.com',
            ]],
            ['no Password Confirmation'=>[
                'name' => 'Felipe',
                'email' => 'felicrosa@gmail.com',
                'password' => '12345678',
            ]],
            ['wrong Password Confirmation'=>[
                'name' => 'Felipe',
                'email' => 'felicrosa@gmail.com',
                'password' => '12345678',
                'password_confirmation' => '1234545678',
            ]],
            ['no email'=>[
                'name' => 'Felipe',
                'password' => '12345678',
                'password_confirmation' => '12345678',
            ]],
            ['invalid email'=>[
                'name' => 'Felipe',
                'email' => 'felicrosamail.com',
                'password' => '12345678',
                'password_confirmation' => '12345678',
            ]],
            ['invalid name'=>[
                'name' => 'Fel4ipe',
                'email' => 'felicrosa@gmail.com',
                'password' => '12345678',
                'password_confirmation' => '12345678',
            ]],
            ['shortPassword'=>[
                'name' => 'Felipe',
                'email' => 'felicrosa@gmail.com',
                'password' => '1454',
                'password_confirmation' => '1454',
            ]],
        ];
    }
}
