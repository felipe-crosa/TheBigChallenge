<?php

namespace Tests\Feature\Submissions;

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
            'patient_id' => $patient->id,
            'symptoms' => 'Symptoms',
            'observations' => 'Observations',
            'speciality' => 'General',
        ];

        $response = $this->postJson('/api/createSubmission', $data);
        $response->assertSuccessful();
        $this->assertDatabaseCount('submissions', 1);
        $response->assertJson(['data' => $data, 'message' => 'Submission created successfully']);
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
            ['noPatient' => [
                'symptoms' => 'Symptoms',
                'observations' => 'Observations',
                'speciality' => 'General',
            ]],
            ['noSymptoms' => [
                'patient_id' => 1,
                'observations' => 'Observations',
                'speciality' => 'General',
            ]],
            ['noSpeciality' => [
                'patient_id' => 1,
                'symptoms' => 'Symptoms',
                'observations' => 'Observations',
            ]],
            ['invalidPatient' => [
                'patient_id' => -1,
                'symptoms' => 'Symptoms',
                'observations' => 'Observations',
                'speciality' => 'General',
            ]],
        ];
    }
}
