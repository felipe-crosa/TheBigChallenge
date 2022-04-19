<?php

namespace Tests\Feature\Submissions;

use App\Models\DoctorInformation;
use App\Models\Submission;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetAllSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_submissions_by_patient()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('patient');
        Sanctum::actingAs($user);
        Submission::factory()->count(4)->create(['patient_id' => $user->id]);
        Submission::factory()->count(5)->create();

        $response = $this->getJson('/api/submissions');
        $response->assertSuccessful();
        $response->assertJsonCount(4, 'data');
    }

    public function test_get_all_submissions_by_doctor()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');

        $otherDoctor = User::factory()->create();
        $otherDoctor->assignRole('doctor');
        DoctorInformation::factory()->create([
            'user_id' => $otherDoctor->id,
        ]);

        Sanctum::actingAs($user);
        Submission::factory()->count(4)->create(['doctor_id' => $user->id]);
        Submission::factory()->count(2)->create();
        Submission::factory()->count(3)->create(['doctor_id' => $otherDoctor->id]);

        $response = $this->getJson('/api/submissions');
        $response->assertSuccessful();
        $response->assertJsonCount(6, 'data');
    }
}
