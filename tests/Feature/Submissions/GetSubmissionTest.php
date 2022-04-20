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

class GetSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_get_submission()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        Sanctum::actingAs($patient);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
        ]);

        $response = $this->getJson("/api/submissions/{$submission->id}");
        $response->assertSuccessful();
        $response->assertJson([
            'status' => 200,
        ]);
    }

    public function test_only_owner_patient_can_view()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
        ]);

        $user = User::factory()->create();
        $user->assignRole('patient');
        Sanctum::actingAs($user);

        $response = $this->getJson("/api/submissions/{$submission->id}");
        $response->assertStatus(404);
    }

    public function test_doctor_can_view_if_submission_not_assigned()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
            'speciality' => 'special',
        ]);

        $user = User::factory()->create();
        $user->assignRole('doctor');
        DoctorInformation::factory()->create([
            'user_id' => $user->id,
            'speciality' => 'special',
        ]);
        Sanctum::actingAs($user);
        $response = $this->getJson("/api/submissions/{$submission->id}");
        $response->assertSuccessful();
        $response->assertJson([
            'status' => 200,
        ]);
    }

    public function test_assign_doctor_can_view_submission()
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
            'doctor_id' => $doctor->id,
            'speciality' => 'special',
        ]);
        $response = $this->getJson("/api/submissions/{$submission->id}");

        $response->assertSuccessful();
        $response->assertJson([
            'status' => 200,
        ]);
    }

    public function test_if_submission_assigned_other_doctors_cant_access()
    {
        (new RolesSeeder())->run();

        $assignedDoctor = User::factory()->create();
        $assignedDoctor->assignRole('doctor');

        $doctor = User::factory()->create();
        $doctor = $doctor->assignRole('doctor');
        Sanctum::actingAs($doctor);
        $docInfo = DoctorInformation::factory()->create([
            'user_id' => $doctor->id,
        ]);

        $patient = User::factory()->create();
        $patient->assignRole('patient');
        PatientInformation::factory()->create(['user_id' => $patient->id]);
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $assignedDoctor->id,
            'speciality' => $docInfo->speciality,
        ]);
        $response = $this->getJson("/api/submissions/{$submission->id}");

        $response->assertStatus(404);
    }
}
