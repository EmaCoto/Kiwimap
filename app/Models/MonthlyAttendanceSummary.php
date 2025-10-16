<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyAttendanceSummary extends Model
{
    protected $fillable = ['user_id','month','timezone','total_seconds'];
    protected $casts = ['month' => 'date'];
}
