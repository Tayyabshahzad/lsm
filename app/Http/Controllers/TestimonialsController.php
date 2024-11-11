<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::get();
        return view('contents.admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contents.admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
            'position' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);  
        Testimonial::create($this->setData($request));
        return redirect()->route('testimonials.index')->with('success', 'Testimonial submitted successfully!');
    }

    private function setData($request)
    { 
        
        
        if (Storage::exists('public/' . $request->file)) { 
            return [
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'position' =>   $request->position, 
                'rating' => $request->rating,
                'file' => $request->file, 
            ]; 

        }

        return [];
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {



        return view('contents.admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
            'position' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'approved' => 'required',
        ]);

        $testimonial->update($validated);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted successfully!');
    }
}
