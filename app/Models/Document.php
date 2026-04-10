<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'patient_id', 'title', 'type', 'file_path', 'file_name',
        'file_type', 'file_size', 'description'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < 3) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getTypeLabelAttribute()
    {
        $types = [
            'prescription' => 'Ordonnance',
            'certificate' => 'Certificat médical',
            'report' => 'Compte rendu',
            'analysis' => 'Analyse médicale',
            'scan' => 'Scanner/IRM'
        ];
        return $types[$this->type] ?? 'Document';
    }
}