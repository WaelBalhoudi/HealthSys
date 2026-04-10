<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id', 'specialty', 'registration_number', 'consultation_fee',
        'diploma', 'cabinet_phone', 'schedule'
    ];

    protected $casts = [
        'schedule' => 'array',
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

    public function waitingRooms()
    {
        return $this->hasMany(WaitingRoom::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user->name;
    }
}