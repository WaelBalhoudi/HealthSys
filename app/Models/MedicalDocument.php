<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalDocument extends Model
{
    protected $fillable = [
        'patient_id', 'title', 'type', 'file_path', 'file_name', 'file_type', 'file_size', 'description'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}