<?php

namespace Tests\Feature\Submissions;

use App\Models\DoctorInformation;
use App\Models\PatientInformation;
use App\Models\Submission;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DiagnoseSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_diagnosis_is_stored()
    {
        $this->markTestSkipped('Does not work on github');

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
        Storage::fake('do');
        $response = $this->postJson("/api/submissions/{$submission->id}/diagnose", [
            'diagnosisFile' => UploadedFile::fake()->create('testing.txt', 10),
        ]);
        Storage::disk('do')->assertExists("felipe/{$response->json()['fileName']}");
    }

    public function test_file_has_to_be_txt()
    {
        $this->markTestSkipped('Does not work on github');

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
        Storage::fake('do');
        $response = $this->postJson("/api/submissions/{$submission->id}/diagnose", [
            'diagnosisFile' => UploadedFile::fake()->create('testing', 10),
        ]);
        $response->assertStatus(422);
    }
}
