<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Events\SignalEvent;
class VideoCall extends Component
{


    public function startCall()
    {
        // Start the call process
        $this->dispatchBrowserEvent('initiateCall');
    }

    public function sendSignal($data)
    {
        broadcast(new SignalEvent($data));
    }


    public function render()
    {
        
        return view('livewire.video-call');
    }
}
