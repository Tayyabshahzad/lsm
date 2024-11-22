<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TrialClassController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Mail\RegistrationConfirmationMail;
use App\Models\Course;
use App\Models\Term;
use App\Models\TrialClass;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|unique:users',
            'country'      => 'required|string',
            'course'       => 'required',
            'term'         => 'required',
        ]); 
        if ($validator->fails()) {
            return response()->json([
                'message' => json_encode($validator->errors()->all()),
            ], 422);
        }  
        $term = Term::find($request->term);      
        $course = Course::find($request->course);    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'country' => $request->country,
        ]); 
        $user->assignRole('student');
        $role = Role::where('name', 'student')->first();
        $term->participants()->attach($user, ['role_id' => $role->id]);
        if ($course) {
            $trialClassController = new TrialClassController();
            $trialClassResponse = $trialClassController->registerTrialClass($request, $user, $course);
            $lastTrialClass = TrialClass::latest()->first(); 
        } 
        Mail::to($user->email)->queue(new RegistrationConfirmationMail($user,$term,$lastTrialClass,$course));
        return response()->json([
            'message' => 'User successfully registered!',
            'user' => $user,
            'trial' => isset($trialClassResponse) ? $trialClassResponse->getData() : null, // Include trial info if available
        ], 201);  
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
