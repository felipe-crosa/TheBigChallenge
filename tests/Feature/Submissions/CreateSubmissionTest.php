<?php

namespace Tests\Feature\Submissions;

use App\Models\DoctorInformation;
use App\Models\PatientInformation;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_submission_is_created_successfully()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        Sanctum::actingAs($patient);

        $data = [
            'symptoms' => 'Symptoms',
            'observations' => 'Observations',
            'speciality' => 'General',
        ];

        $response = $this->postJson('/api/createSubmission', $data);
        $response->assertSuccessful();
        $this->assertDatabaseCount('submissions', 1);
        $response->assertJson(['message' => 'Submission created successfully']);
    }

    public function test_only_patients_can_create()
    {
        (new RolesSeeder())->run();
        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');
        DoctorInformation::factory()->create(['user_id' => $doctor->id]);
        Sanctum::actingAs($doctor);

        $response = $this->postJson('/api/createSubmission');
        $response->assertForbidden();
    }

    /**
     * @dataProvider  invalidSubmissionDataProvider
     */
    public function test_submission_cant_be_created_with_invalid_data($data)
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        Sanctum::actingAs($patient);
        $response = $this->postJson('/api/createSubmission', $data);
        $response->assertStatus(422);
    }

    public function invalidSubmissionDataProvider()
    {
        return [

            ['noSymptoms' => [
                'observations' => 'Observations',
                'speciality' => 'General',
            ]],
            ['noSpeciality' => [
                'symptoms' => 'Symptoms',
                'observations' => 'Observations',
            ]],
        ];
    }
}
