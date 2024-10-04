<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Templates;

class TemplateGallery extends Component
{
    public $templates;
    public $selected;

    public function mount(){
        $this->templates = Templates::all();
    }

    public function select($templateId){
        $this->selected = Templates::find($templateId);
    }
    public function render()
    {
        return view('livewire.template-gallery');
    }
}
