<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricing;
use App\Models\Course;
use App\Models\CoursePricing;

class PricingController extends Controller
{
    public function index()
    {
        $courses = Course::with('pricings')->paginate(10);
        return view("contents.admin.courses.pricing", compact("courses"));
    }
}
