<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\HomeServices;
use App\Events\SignalEvent;
use App\Models\Course;
use App\Models\TrialClass;
use App\Models\User;

class FrontController extends Controller
{


    /**
     * Make HomePage Index
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */

     public function startCall()
     { 
         $this->dispatchBrowserEvent('initiateCall');
     }
     public function sendSignal($data)
     {
         broadcast(new SignalEvent($data));
     }

    public function index(HomeServices $homeServices)
    {

        $homeCompactReturn = $homeServices->homeIndex();

        return view('contents.front.index.welcome', $homeCompactReturn);
    }

    public function video()
    { 
        $course = Course::first();
        $user = User::first();
        $trialClassResponse = TrialClass::first();
        return view('emails.registration_confirmation',compact('course','user','trialClassResponse'));
    }



    
    
}
