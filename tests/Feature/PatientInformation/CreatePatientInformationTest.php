<?php

namespace Tests\Feature\PatientInformation;

use App\Models\PatientInformation;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePatientInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_information_is_created()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('patient');
        Sanctum::actingAs($user);
        $data = [
            'height'=>40,
            'date_of_birth' => '2002-06-10',
            'weight' => 70.4,
            'gender' => 'male',
            'allergies' => 'Alergic to nuts',
            'medical_conditions' => 'Asmatic',
        ];

        $response = $this->postJson('/api/createPatientInformation', $data);
        $this->assertDatabaseHas('patients', $data);
        $response->assertSuccessful();
        $response->assertJson(['status'=>200, 'message'=>'Information has been successfully created']);
    }

    /**
     * @dataProvider invalidPatientInformationDataProvider
     */
    public function test_cant_create_patient_information_with_invalid_data($data)
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('patient');
        Sanctum::actingAs($user);
        $response = $this->postJson('/api/createPatientInformation', $data);
        $response->assertStatus(422);
    }

    public function test_only_patients_can_create()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        Sanctum::actingAs($user);
        $data = [
            'height'=>40,
            'date_of_birth' => '2002-06-10',
            'weight' => 70.4,
            'gender' => 'male',
            'allergies' => 'Alergic to nuts',
            'medical_conditions' => 'Asmatic',
        ];
        $response = $this->postJson('/api/createPatientInformation', $data);
        $response->assertForbidden();
    }

    public function test_users_with_patient_information_cant_create_again()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        PatientInformation::factory()->create(['user_id'=>$user->id]);
        Sanctum::actingAs($user);
        $data = [
            'height'=>40,
            'date_of_birth' => '2002-06-10',
            'weight' => 70.4,
            'gender' => 'male',
            'allergies' => 'Alergic to nuts',
            'medical_conditions' => 'Asmatic',
        ];
        $response = $this->postJson('/api/createPatientInformation', $data);
        $response->assertForbidden();
    }

    public function invalidPatientInformationDataProvider()
    {
        return [
            ['no height' => [
                'date_of_birth' => '2002-06-10',
                'weight' => 70.4,
                'gender' => 'male',
                'allergies' => 'Alergic to nuts',
                'medical_conditions' => 'Asmatic',
            ]],
            ['negtive weight' => [
                'height' => 172.4,
                'date_of_birth' => '2025-06-10',
                'weight' => -70.4,
                'gender' => 'male',
                'allergies' => 'Alergic to nuts',
                'medical_conditions' => 'Asmatic',
            ]],
            ['not male nor female' => [
                'height' => 172.4,
                'date_of_birth' => '2002-06-10',
                'weight' => 70.4,
                'gender' => 'other',
                'allergies' => 'Alergic to nuts',
                'medical_conditions' => 'Asmatic',
            ]],
            ['no gender' => [
                'height' => 172.4,
                'date_of_birth' => '2002-06-10',
                'weight' => 70.4,
                'allergies' => 'Alergic to nuts',
                'medical_conditions' => 'Asmatic',
            ]],
            ['no date of birth' => [
                'height' => 172.4,
                'weight' => 70.4,
                'gender' => 'male',
                'allergies' => 'Alergic to nuts',
                'medical_conditions' => 'Asmatic',
            ]],
            ['no weight' => [
                'height' => 172.4,
                'date_of_birth' => '2002-06-10',
                'gender' => 'male',
                'allergies' => 'Alergic to nuts',
                'medical_conditions' => 'Asmatic',
            ]],

        ];
    }
}
