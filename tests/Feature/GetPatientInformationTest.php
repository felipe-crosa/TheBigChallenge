<?php

namespace Tests\Feature;

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
        $data = [
            'height' => 172.4,
            'date_of_birth' => '2002-06-10',
            'weight' => 70.4,
            'gender' => 'male',
            'allergies' => 'Alergic to nuts',
            'medical_conditions' => 'Asmatic',
        ];

        $user->patient()->create($data);
        $response = $this->getJson('api/getPatientInformation');
        $response->assertSuccessful();

        $response->assertJson($data);
    }
}
