<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ExampleComponent extends Component
{
    public $something = 'wow';

    public function mount()
    {
        if ($this->something === 'wow') {
            return redirect()->route('home');
        }
    }

    public function render()
    {
        return view('livewire.example-component');
    }
}
