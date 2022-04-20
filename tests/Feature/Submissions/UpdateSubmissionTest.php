<?php

namespace Tests\Feature\Submissions;

use App\Models\PatientInformation;
use App\Models\Submission;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_modify_submission()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        Sanctum::actingAs($patient);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
        ]);
        $response = $this->patchJson("/api/submissions/{$submission->id}/update", [
            'symptoms' => 'Symptoms',
            'observations' => 'Observations',
            'speciality' => 'General',
        ]);

        $response->assertSuccessful();
        $response->assertJsonFragment([
            'symptoms' => 'Symptoms',
            'observations' => 'Observations',
            'speciality' => 'General',
        ]);
    }

    public function test_user_can_only_modify_before_doctor_is_assigned()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        Sanctum::actingAs($patient);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => User::factory()->create(),
        ]);
        $response = $this->patchJson("/api/submissions/{$submission->id}/update", [
            'symptoms' => 'Symptoms',
            'observations' => 'Observations',
            'speciality' => 'General',
        ]);

        $response->assertForbidden();
    }
}
