<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetPatientInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_obtainning_patient_information_from_user()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->assignRole('patient');

        $patient = Patient::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson('api/getPatientInformation');
        $response->assertSuccessful();

        $response->assertJson([
            'height' => $patient->height,
            'weight' => $patient->weight,
            'gender' => $patient->gender,
            'date_of_birth' => $patient->date_of_birth,
            'allergies' => $patient->allergies,
            'medical_conditions' => $patient->medical_conditions,
        ]);
    }

    public function test_user_without_patient_data_cant_access()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->assignRole('patient');
        $response = $this->getJson('api/getPatientInformation');
        $response->assertForbidden();
    }
}
