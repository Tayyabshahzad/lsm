<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $courses = Course::with(['Terms','Department'])->where('type','!=','science')->orderBy('id','desc')->get();
        return response()->json($courses);
    }

    public function courseScience(): JsonResponse

    {
        $courses = Course::with(['Terms','Department'])->where('type','science')->orderBy('id','desc')->get();
        return response()->json($courses);
    } 
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with(['Terms','Department','pricings'])->where('id',$id)->first();
        if ($course) {
            $course->terms->transform(function ($term) {
                $term->description = strlen($term->description) > 100 ? substr($term->description, 0, 400) . '...' : $term->description;
                return $term;
            });
        }
        return response()->json($course);
    }

    public function getTerms($id){
        $course = Course::with(['Terms','Department','pricings'])->where('id',$id)->first(); 
        return response()->json([
            'terms'=>$course->Terms
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
