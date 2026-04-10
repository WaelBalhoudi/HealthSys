<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id', 'insurance_number', 'insurance_company', 'emergency_contact',
        'emergency_phone', 'allergies', 'medical_history', 'blood_type', 'weight', 'height'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function waitingRooms()
    {
        return $this->hasMany(WaitingRoom::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getAgeAttribute()
    {
        return $this->user->birth_date ? \Carbon\Carbon::parse($this->user->birth_date)->age : null;
    }
}