<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialty'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function licensedStates()
    {
        return $this->belongsToMany(State::class, 'licenses')
            ->withPivot(['status', 'expiration_date']);
    }
}
