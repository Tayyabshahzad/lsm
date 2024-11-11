<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\CoursePricing; 

class ManageCoursePricing extends Component
{
    public $courseId;
    public $pricings = [];
    public $price, $billing_cycle = 'monthly', $classes_per_week = 1, $course_duration = 60, $is_best = false;

    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $this->pricings = CoursePricing::where('course_id', $courseId)->get();
    }

    public function savePricing()
    {
        $this->validate([
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string',
            'classes_per_week' => 'required|integer|min:1',
            'course_duration' => 'required|integer|min:1',
        ]);

        CoursePricing::create([
            'course_id' => $this->courseId,
            'price' => $this->price,
            'billing_cycle' => $this->billing_cycle,
            'classes_per_week' => $this->classes_per_week,
            'course_duration' => $this->course_duration,
            'is_best' => $this->is_best,
        ]);

        $this->resetFields();
        $this->pricings = CoursePricing::where('course_id', $this->courseId)->get();
    }

    public function resetFields()
    {
        $this->price = null;
        $this->billing_cycle = 'monthly';
        $this->classes_per_week = 1;
        $this->course_duration = 60;
        $this->is_best = false;
    }

    public function render()
    {
        return view('livewire.manage-course-pricing');
    }
}
