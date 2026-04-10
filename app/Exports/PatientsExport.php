<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PatientsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Patient::with('user');
        
        if ($this->search) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%");
            });
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Nom complet',
            'Email',
            'Téléphone',
            'Date naissance',
            'Âge',
            'Adresse',
            'Groupe sanguin',
            'Poids (kg)',
            'Taille (cm)',
            'Mutuelle',
            'Numéro mutuelle',
            'Allergies',
            'Antécédents médicaux',
            'Contact urgence',
            'Téléphone urgence',
            'Nombre de consultations',
            'Date d\'inscription'
        ];
    }

    public function map($patient): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        return [
            $rowNumber,
            $patient->user->name,
            $patient->user->email,
            $patient->user->phone,
            $patient->user->birth_date ? \Carbon\Carbon::parse($patient->user->birth_date)->format('d/m/Y') : '-',
            $patient->age ?? '-',
            $patient->user->address ?? '-',
            $patient->blood_type ?? '-',
            $patient->weight ?? '-',
            $patient->height ?? '-',
            $patient->insurance_company ?? '-',
            $patient->insurance_number ?? '-',
            $patient->allergies ?? '-',
            $patient->medical_history ?? '-',
            $patient->emergency_contact ?? '-',
            $patient->emergency_phone ?? '-',
            $patient->consultations->count(),
            $patient->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:R1' => ['fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1a5f7a']
            ]],
        ];
    }
}