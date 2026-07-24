<?php

namespace App\Models\Information;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    /** @use HasFactory<\Database\Factories\Information\IndexFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'information',
        'notes',
    ];
}
