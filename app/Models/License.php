<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id','state_id','license_number','license_type','issued_date',
        'expiration_date','active_license_link','expired_license_link',
        'dea_number','notes','cost','mal_praxis_required','forms',
        'need_physical_office','insurance','status'
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiration_date' => 'date',
        'forms' => 'array',
        'insurance' => 'array',
        'mal_praxis_required' => 'boolean',
        'need_physical_office' => 'boolean',
    ];

    public function doctor(){ return $this->belongsTo(Doctor::class); }
    public function state(){ return $this->belongsTo(State::class); }
}

