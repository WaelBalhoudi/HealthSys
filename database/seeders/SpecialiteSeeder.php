<?php

namespace Database\Seeders;

use App\Models\Specialite;
use Illuminate\Database\Seeder;

class SpecialiteSeeder extends Seeder
{
    public function run(): void
    {
        $specialites = [
            'Cardiologue', 'Dermatologue', 'Pédiatre', 'Gynécologue',
            'Ophtalmologue', 'Dentiste', 'Orthopédiste', 'Neurologue',
            'Psychiatre', 'Généraliste'
        ];
        
        foreach ($specialites as $specialite) {
            Specialite::create(['nom' => $specialite]);
        }
    }
}