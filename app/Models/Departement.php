<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $fillable = ['nom', 'description'];

    public function secretaries()
    {
        return $this->hasMany(User::class, 'departement_id')->where('role', 'secretaire');
    }
}