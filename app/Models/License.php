<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id','state_id',
        'issued_date','expiration_date',
        'has_active_link','expired_license_link',
        'notes','cost','mal_praxis_required','forms','need_physical_office','insurance',
        'status',
    ];

    protected $casts = [
        'issued_date'      => 'date',
        'expiration_date'  => 'date',
        'has_active_link'  => 'boolean',
        'mal_praxis_required' => 'boolean',
        'need_physical_office'=> 'boolean',
        'forms'            => 'array',
        'insurance'        => 'array',
    ];

    public function doctor(){ return $this->belongsTo(Doctor::class); }
    public function state(){ return $this->belongsTo(State::class); }
}
