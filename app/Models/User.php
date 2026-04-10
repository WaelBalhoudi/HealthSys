<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address', 
        'birth_date', 'specialite_id', 'departement_id','avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function isAdmin()
    {
        return $this->role === 'chef_medecine';
    }

    public function isDoctor()
    {
        return $this->role === 'doctor';
    }

    public function isSecretary()
    {
        return $this->role === 'secretaire';
    }

    public function isPatient()
    {
        return $this->role === 'patient';
    }
}