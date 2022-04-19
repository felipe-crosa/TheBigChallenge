<?php

namespace Tests\Feature\Submissions;

use App\Models\Submission;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_submission()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
        ]);
        Sanctum::actingAs($patient);
        $response = $this->deleteJson("/api/submissions/{$submission->id}/delete");
        $response->assertSuccessful();
        $response->assertJson(['message' => 'The submission has been deleted']);
    }

    public function test_only_owner_can_delete()
    {
        (new RolesSeeder())->run();
        $submission = Submission::factory()->create();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        Sanctum::actingAs($patient);
        $response = $this->deleteJson("/api/submissions/{$submission->id}/delete");
        $response->assertStatus(404);
    }

    public function test_deleting_non_existing_submission()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create();
        $patient->assignRole('patient');
        Sanctum::actingAs($patient);
        $response = $this->deleteJson('/api/submissions/-1/delete');
        $response->assertStatus(404);
    }
}
