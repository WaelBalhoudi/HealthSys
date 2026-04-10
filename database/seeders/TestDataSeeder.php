<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Specialite;
use App\Models\Departement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les spécialités
        $specialites = ['Cardiologue', 'Dermatologue', 'Pédiatre', 'Gynécologue', 'Généraliste'];
        foreach ($specialites as $spec) {
            Specialite::create(['nom' => $spec]);
        }
        
        // Créer les départements
        $departements = ['Accueil', 'Consultations', 'Urgences', 'Administration'];
        foreach ($departements as $dep) {
            Departement::create(['nom' => $dep]);
        }
        
        // Créer un médecin
        $doctorUser = User::create([
            'name' => 'Dr Ahmed Benali',
            'email' => 'doctor@healthsys.com',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'phone' => '0612345678',
            'address' => 'Casablanca',
            'birth_date' => '1975-06-15',
        ]);
        
        Doctor::create([
            'user_id' => $doctorUser->id,
            'specialty' => 'Cardiologue',
            'registration_number' => 'MED12345',
            'consultation_fee' => 300,
        ]);
        
        // Créer un patient
        $patientUser = User::create([
            'name' => 'Karim Alaoui',
            'email' => 'patient@healthsys.com',
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'phone' => '0698765432',
            'address' => 'Rabat',
            'birth_date' => '1990-03-20',
        ]);
        
        Patient::create([
            'user_id' => $patientUser->id,
            'insurance_number' => 'INS123456',
            'insurance_company' => 'CNSS',
            'blood_type' => 'O+',
        ]);
        
        // Créer un rendez-vous
        Appointment::create([
            'patient_id' => 1,
            'doctor_id' => 1,
            'date_time' => now()->addDays(3),
            'duration' => 30,
            'status' => 'confirmed',
            'type' => 'general',
            'reason' => 'Consultation de routine',
        ]);
        
        $this->command->info('Données de test créées avec succès !');
    }
}