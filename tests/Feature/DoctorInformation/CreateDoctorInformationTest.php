<?php

namespace Tests\Feature\DoctorInformation;

use App\Models\DoctorInformation;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateDoctorInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_is_created()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        Sanctum::actingAs($user);
        $data = [
            'speciality' => 'Pediatrics',
            'institution' => 'the British Hospital',
        ];
        $response = $this->postJson('/api/createDoctorInformation', $data);
        $response->assertSuccessful();
        $response->assertJson([
            'status' => 200,
            'message' => 'Information created successfully',
        ]);
        $this->assertDatabaseHas('doctor_information', ['speciality'=>'Pediatrics', 'institution'=>'The British Hospital']);
    }

    /**
     * @dataProvider  invalidDoctorInformationDataProvider
     */
    public function test_creation_of_information_with_invalid_data($data)
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        Sanctum::actingAs($user);
        $response = $this->postJson('/api/createDoctorInformation', $data);
        $response->assertStatus(422);
    }

    public function test_only_doctors_can_create()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('patient');
        Sanctum::actingAs($user);
        $data = [
            'speciality' => 'Pediatrics d',
            'institution' => 'The British Hospital',
        ];
        $response = $this->postJson('/api/createDoctorInformation', $data);
        $response->assertForbidden();
    }

    public function test_users_with_doctor_information_cant_create_again()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        DoctorInformation::factory()->create(['user_id'=>$user->id]);
        $user->assignRole('doctor');
        Sanctum::actingAs($user);
        $data = [
            'speciality' => 'Pediatrics',
            'institution' => 'The British Hospital',
        ];
        $response = $this->postJson('/api/createDoctorInformation', $data);
        $response->assertForbidden();
    }

    public function invalidDoctorInformationDataProvider()
    {
        return [
            ['no speciality'=>[
                'institution'=>'British Hospital',
            ]],
            ['numeric speciality'=>[
                'speciality'=>'fdg32',
                'institution'=>'British Hospital',
            ]],
            ['no institution'=>[
                'speciality'=> 'Pediatrics',
            ]],
        ];
    }
}
