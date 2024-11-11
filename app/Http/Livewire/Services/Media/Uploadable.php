<?php

namespace App\Http\Livewire\Services\Media;

use App\Traits\WithRuleUploaded;
use Livewire\Component;
use Livewire\WithFileUploads;



class Uploadable extends Component
{

    use WithFileUploads, WithRuleUploaded;
    

    public string $path = '';
    public $file;

    public string $target = '';

    public function updatedFile()
    {
        
        $this->validate($this->getTargetRule($this->target));
        $storedFilePath = $this->file->store($this->path, 'public');
        $this->emitUp('fileUploaded', $storedFilePath);
        $this->file = $storedFilePath;

    }


    public function render()
    {
        
        return view('livewire.services.media.uploadable');
    }
}
