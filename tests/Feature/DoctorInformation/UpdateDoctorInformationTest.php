<?php

namespace Tests\Feature\DoctorInformation;

use App\Models\DoctorInformation;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateDoctorInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_information_is_updated()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        $doctorInformation = DoctorInformation::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $data = [
            'speciality' => 'Pediatrics',
            'institution' => 'The British Hospital',
        ];
        $response = $this->patchJson('/api/updateDoctorInformation', $data);
        $response->assertSuccessful();
        $response->assertJson(['data' => $data]);
        $this->assertDatabaseHas('doctor_information', $data);
    }

    public function test_only_doctors_can_update_their_information()
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('patient');
        Sanctum::actingAs($user);
        $response = $this->patchJson('/api/updateDoctorInformation');
        $response->assertForbidden();
    }

    /**
     * @dataProvider invalidDoctorInformationDataProvider
     */
    public function test_user_cant_update_information_with_invalid_data($data)
    {
        (new RolesSeeder())->run();
        $user = User::factory()->create();
        $user->assignRole('doctor');
        DoctorInformation::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $response = $this->patchJson('/api/updateDoctorInformation', $data);
        $response->assertStatus(422);
    }

    public function invalidDoctorInformationDataProvider()
    {
        return [
            ['no speciality'=>[
                'institution'=>'British Hospital',
            ]],
            ['numeric speciality'=>[
                'speciality'=>'fdg32',
                'institution'=>'British Hospital',
            ]],
            ['no institution'=>[
                'speciality'=> 'Pediatrics',
            ]],
        ];
    }
}
