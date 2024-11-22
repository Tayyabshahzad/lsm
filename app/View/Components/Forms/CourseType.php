<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class CourseType extends Component
{    
    /**
     * model
     *
     * @var \Illuminate\Support\Collection<int, mixed>
     */
   
    public string $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name)
    { 
        $this->name = 'type'; 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {


        return view('components.forms.drop-down-course');
    }
}
