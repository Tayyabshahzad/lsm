<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
class TestimonialsController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::all();
        return response()->json($testimonials);
    }
}
