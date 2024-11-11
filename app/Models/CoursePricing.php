<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePricing extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id', 'price', 'billing_cycle', 'classes_per_week', 'course_duration', 'is_best'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
