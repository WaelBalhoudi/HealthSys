<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingRoom extends Model
{
    protected $fillable = [
        'appointment_id', 'patient_id', 'doctor_id', 'arrival_time',
        'start_time', 'end_time', 'priority', 'status', 'estimated_duration'
    ];

    protected $casts = [
        'arrival_time' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}