<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\HomeServices;
use App\Events\SignalEvent;
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
        return view('video.index');
    }



    
    
}
