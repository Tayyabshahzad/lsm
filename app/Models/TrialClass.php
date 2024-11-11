<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialClass extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'course_id', 'status', 'trial_start', 'trial_end'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A trial class is associated with a course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
