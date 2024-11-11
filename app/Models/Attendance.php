<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date', 'check_in_time', 'check_out_time', 'is_present','remarks'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'date' => 'date',
        'is_present' => 'boolean',
    ];
    public function getCheckInTimeAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function getCheckOutTimeAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
}
