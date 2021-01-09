<?php

namespace App\Http\Livewire\Admin;

use App\Models\Substance;
use Livewire\Component;

class SubstanceCreateModal extends Component
{
    protected $listeners = ['openSubstanceCreateModal' => 'open'];

    protected $rules = [
        'name' => 'required|min:3|max:255'
    ];

    public $displayModal;
    public $name;

    public function open()
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->displayModal = true;
        $this->name = '';
    }

    public function close()
    {
        $this->displayModal = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $validatedData = $this->validate();

        $validatedData['visible'] = true;

        Substance::create($validatedData);

        $this->close();

        $this->emit('substanceCreated');
    }

    public function render()
    {
        return view('livewire.admin.substance-create-modal');
    }
}
