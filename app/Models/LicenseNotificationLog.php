<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseNotificationLog extends Model
{
    protected $fillable = ['license_id','offset_days','sent_at'];
    protected $casts = ['sent_at' => 'datetime'];
}
