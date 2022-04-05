<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdatePatientInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_information_is_updated_successfully()
    {
        (new RolesSeeder)->run();
        $user = User::factory()->create();
        $patient = Patient::create(['user_id' => $user->id]);
        $user->assignRole('patient');
        Sanctum::actingAs($user);
        $data = [
            'height' => 172.4,
            'date_of_birth' => '2002-06-10',
            'weight' => 70.4,
            'gender' => 'male',
            'allergies' => 'Alergic to nuts',
            'medical_conditions' => 'Asmatic',
        ];
        $this->patchJson('/api/updatePatient', $data)->assertSuccessful();
    }

    public function test_only_patients_can_update_their_information()
    {
        (new RolesSeeder)->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        Sanctum::actingAs($user);
        $data = [
            'height' => 172.4,
            'date_of_birth' => '2002-06-10',
            'weight' => 70.4,
            'gender' => 'male',
            'allergies' => 'Alergic to nuts',
            'medical_conditions' => 'Asmatic',
        ];
        $this->patchJson('/api/updatePatient', $data)->assertForbidden();
    }

    /**
     * @dataProvider invalidPatientDataProvider
     */
    public function test_invalid_patient_data($data)
    {
        (new RolesSeeder)->run();
        $user = User::factory()->create();
        $patient = Patient::create(['user_id' => $user->id]);
        $user->assignRole('patient');
        Sanctum::actingAs($user);
        $this->patchJson('/api/updatePatient', $data)->assertStatus(422);
    }

    public function invalidPatientDataProvider()
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
