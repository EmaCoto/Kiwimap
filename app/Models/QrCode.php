<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $fillable = [
        'name',
        'type',
        'payload',
        'content',
        'foreground_color',
        'background_color',
        'size',
        'logo_path',
        'qr_path',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
