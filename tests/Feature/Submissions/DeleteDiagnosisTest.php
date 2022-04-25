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

class DeleteDiagnosisTest extends TestCase
{
    use RefreshDatabase;

    public function test_deletion_of_diagnosis_file()
    {
        $this->markTestSkipped('Does not work on github');

        Storage::fake('do');

        $file = UploadedFile::fake()->create('testing.txt', 10);
        Storage::disk('do')->put(
            'felipe/testing',
            file_get_contents($file)
        );

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
            'diagnosis' => 'testing',
        ]);

        $response = $this->postJson("/api/submissions/{$submission->id}/deleteDiagnosis");

        $response->assertSuccessful();
    }
}
