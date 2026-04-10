<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AppointmentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $status;
    protected $doctorId;

    public function __construct($startDate = null, $endDate = null, $status = null, $doctorId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
        $this->doctorId = $doctorId;
    }

    public function collection()
    {
        $query = Appointment::with(['patient.user', 'doctor.user']);
        
        if ($this->startDate) {
            $query->whereDate('date_time', '>=', $this->startDate);
        }
        
        if ($this->endDate) {
            $query->whereDate('date_time', '<=', $this->endDate);
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        if ($this->doctorId) {
            $query->where('doctor_id', $this->doctorId);
        }
        
        return $query->orderBy('date_time', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Date et heure',
            'Patient',
            'Email patient',
            'Téléphone patient',
            'Médecin',
            'Spécialité',
            'Type',
            'Statut',
            'Motif',
            'Durée (min)',
            'Créé le'
        ];
    }

    public function map($appointment): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        $statusLabels = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmé',
            'cancelled' => 'Annulé',
            'completed' => 'Terminé'
        ];
        
        $typeLabels = [
            'general' => 'Général',
            'emergency' => 'Urgence',
            'follow_up' => 'Suivi',
            'specialist' => 'Spécialiste'
        ];
        
        return [
            $rowNumber,
            $appointment->date_time->format('d/m/Y H:i'),
            $appointment->patient->user->name,
            $appointment->patient->user->email,
            $appointment->patient->user->phone,
            'Dr. ' . $appointment->doctor->user->name,
            $appointment->doctor->specialty,
            $typeLabels[$appointment->type] ?? $appointment->type,
            $statusLabels[$appointment->status] ?? $appointment->status,
            $appointment->reason ?? '-',
            $appointment->duration,
            $appointment->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:L1' => ['fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1a5f7a']
            ]],
        ];
    }
}