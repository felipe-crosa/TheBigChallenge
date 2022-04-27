<?php

namespace Database\Seeders;

use App\Models\DoctorInformation;
use App\Models\PatientInformation;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new RolesSeeder())->run();
        $patient = User::factory()->create([
            'email' => 'patient@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        PatientInformation::factory()->create([
            'user_id' => $patient->id,
        ]);

        $patient->assignRole('patient');

        $doctor = User::factory()->create([
            'email' => 'doctor@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $doctor->assignRole('doctor');

        DoctorInformation::factory()->create([
            'user_id' => $doctor->id,
            'speciality' => 'General',
        ]);

        $submission = Submission::factory()->create([
            'patient_id' => $patient->id,
            'speciality' => 'General',
            'doctor_id' => $doctor->id,
        ]);
    }
}
