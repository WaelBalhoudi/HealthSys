<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoicesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $status;
    protected $startDate;
    protected $endDate;

    public function __construct($status = null, $startDate = null, $endDate = null)
    {
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Invoice::with(['patient.user']);
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        if ($this->startDate) {
            $query->whereDate('issue_date', '>=', $this->startDate);
        }
        
        if ($this->endDate) {
            $query->whereDate('issue_date', '<=', $this->endDate);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'N° Facture',
            'Patient',
            'Email',
            'Téléphone',
            'Montant (DT)',
            'Payé (DT)',
            'Reste (DT)',
            'Statut',
            'Date d\'émission',
            'Date d\'échéance',
            'Description',
            'Créé le'
        ];
    }

    public function map($invoice): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        $statusLabels = [
            'pending' => 'En attente',
            'paid' => 'Payée',
            'partially_paid' => 'Partiellement payée',
            'cancelled' => 'Annulée'
        ];
        
        return [
            $rowNumber,
            $invoice->invoice_number,
            $invoice->patient->user->name,
            $invoice->patient->user->email,
            $invoice->patient->user->phone,
            number_format($invoice->amount, 2),
            number_format($invoice->paid_amount, 2),
            number_format($invoice->amount - $invoice->paid_amount, 2),
            $statusLabels[$invoice->status] ?? $invoice->status,
            $invoice->issue_date->format('d/m/Y'),
            $invoice->due_date->format('d/m/Y'),
            $invoice->description ?? '-',
            $invoice->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:M1' => ['fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1a5f7a']
            ]],
            'F:F' => ['font' => ['bold' => true]],
            'G:G' => ['font' => ['color' => ['rgb' => '28a745']]],
            'H:H' => ['font' => ['color' => ['rgb' => 'dc3545']]],
        ];
    }
}