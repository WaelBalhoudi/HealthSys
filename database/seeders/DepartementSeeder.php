<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
        $departements = [
            'Accueil', 'Consultations', 'Urgences', 'Hospitalisation',
            'Laboratoire', 'Radiologie', 'Pharmacie', 'Administration'
        ];
        
        foreach ($departements as $departement) {
            Departement::create(['nom' => $departement]);
        }
    }
}