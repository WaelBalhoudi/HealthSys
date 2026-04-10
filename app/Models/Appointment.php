<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'created_by', 'date_time', 'duration',
        'status', 'type', 'reason', 'notes', 'reminder_sent'
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'reminder_sent' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }

    public function waitingRoom()
    {
        return $this->hasOne(WaitingRoom::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->date_time->format('d/m/Y H:i');
    }
}