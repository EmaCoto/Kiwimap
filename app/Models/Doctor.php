<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','specialty'];

    public function user()    { return $this->belongsTo(User::class); }
    public function licenses(){ return $this->hasMany(License::class); }

    // Helper: estados con licencia activa
    public function licensedStates()
    {
        return $this->belongsToMany(State::class, 'licenses')
            ->withPivot(['license_number','status','expiration_date']);
    }
}
