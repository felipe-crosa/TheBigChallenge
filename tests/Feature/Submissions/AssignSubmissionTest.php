<?php

namespace Tests\Feature\Submissions;

use App\Models\DoctorInformation;
use App\Models\PatientInformation;
use App\Models\Submission;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AssignSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_can_successfully_assign_himself_to_a_submission()
    {
        (new RolesSeeder())->run();
        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');
        Sanctum::actingAs($doctor);
        DoctorInformation::factory()->create([
            'user_id' => $doctor->id,
            'speciality' => 'special',
        ]);

        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
            'speciality' => 'special',
        ]);

        $response = $this->patchJson("/api/submissions/{$submission->id}/assign");
        $response->assertSuccessful();
        $this->assertDatabaseCount('submissions', 1);
        $this->assertDatabaseHas('submissions', ['doctor_id' => $doctor->id]);
        $response->assertJsonFragment(['status' => 200]);
    }

    public function test_only_doctors_can_be_assigned_submissions()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        Sanctum::actingAs($patient);
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
            'speciality' => 'special',
        ]);
        $this->patchJson("/api/submissions/{$submission->id}/assign")->assertForbidden();
    }

    public function test_doctors_cant_be_assigned_to_an_already_assigned_submission()
    {
        (new RolesSeeder())->run();

        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
            'speciality' => 'special',
            'doctor_id' => User::factory()->create(),
        ]);

        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');
        Sanctum::actingAs($doctor);
        DoctorInformation::factory()->create(['user_id' => $doctor->id]);
        $this->patchJson("/api/submissions/{$submission->id}/assign")->assertNotFound();
    }

    public function test_doctors_need_to_complete_their_information_to_be_assigned()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
            'speciality' => 'special',
        ]);

        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');
        Sanctum::actingAs($doctor);
        $this->patchJson("/api/submissions/{$submission->id}/assign")->assertForbidden();
    }
}
