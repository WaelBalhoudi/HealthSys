<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'consultation_id', 'patient_id', 'doctor_id', 'medications',
        'instructions', 'prescription_date', 'valid_until', 'status'
    ];

    protected $casts = [
        'prescription_date' => 'date',
        'valid_until' => 'date',
        'medications' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function isExpired()
    {
        return $this->valid_until && $this->valid_until < now();
    }
}