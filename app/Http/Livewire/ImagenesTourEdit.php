<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenesTourEdit extends Component
{
    use WithFileUploads;
        
    public $imagenes=[];
    public $imagenesanteriores=[];


    public function mount($imagenesanteriores)
    {
        foreach($imagenesanteriores as $i => $imagen){
            $this->imagenesanteriores[$i]=$imagen->nombre;
        }
    }

    public function eliminarfotos($i){
        unset($this->imagenesanteriores[$i]);
        $this->imagenesanteriores = array_values($this->imagenesanteriores);
    }

    public function render()
    {
        return view('livewire.imagenes-tour-edit');
    }
}
