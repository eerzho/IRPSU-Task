<?php

namespace App\Http\Livewire\Admin;

use App\Models\Substance;
use Livewire\Component;

class SubstanceUpdateModal extends Component
{
    protected $listeners = ['openSubstanceUpdateModal' => 'open'];

    protected $rules = [
        'name' => 'required|min:3|max:255'
    ];

    public $displayModal;
    public $item;
    public $name;

    public function open(Substance $item)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->displayModal = true;
        $this->name = $item->name;
        $this->item = $item;
    }

    public function close()
    {
        $this->displayModal = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $validatedData = $this->validate();

        $this->item->update($validatedData);

        $this->close();

        $this->emit('substanceCreated');
    }

    public function render()
    {
        return view('livewire.admin.substance-update-modal');
    }
}
