<?php

namespace Tests\Feature\DoctorInformation;

use App\Models\DoctorInformation;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetDoctorInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_obtain_doctor_information()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        $doctorInformation = DoctorInformation::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/getDoctorInformation');
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                'speciality' => $doctorInformation->speciality,
                'institution' => $doctorInformation->institution, ],
        ]);
    }

    public function test_only_doctors_can_access()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('patient');
        $doctorInformation = DoctorInformation::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/getDoctorInformation');
        $response->assertForbidden();
    }

    public function test_only_doctors_with_information_can_access()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/getDoctorInformation');
        $response->assertForbidden();
    }
}
