<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    protected $fillable = ['nom', 'description'];

    public function doctors()
    {
        return $this->hasMany(User::class, 'specialite_id')->where('role', 'doctor');
    }
}