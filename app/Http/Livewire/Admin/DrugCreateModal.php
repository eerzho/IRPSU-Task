<?php

namespace App\Http\Livewire\Admin;

use App\Models\Drug;
use App\Models\Substance;
use Livewire\Component;

class DrugCreateModal extends Component
{
    protected $listeners = ['openDrugCreateModal' => 'open'];

    protected $rules = [
        'name' => 'required|min:3|max:255'
    ];

    public $displayModal;
    public $name;
    public $step;
    public $values;
    public $perPage = 0;

    public function open()
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->displayModal = true;
        $this->name = '';
        $this->step = 1;
    }

    public function close()
    {
        $this->displayModal = false;
    }

    public function stepChange($type)
    {
        $type == 'next' ? $this->step++ : $this->step--;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $validatedData = $this->validate();

        $item = Drug::create($validatedData);

        $item->substances()->attach(array_keys(array_filter($this->values)));

        $this->close();

        $this->emit('drugCreated');
    }

    public function getSubstances()
    {
        $items = Substance::where('visible', true)->skip($this->perPage * 5)->limit(5)->get();

        return $items;
    }

    public function pageChange($type)
    {
        $type == 'next' ? $this->perPage++ : ($this->perPage > 0 ? $this->perPage-- : $this->perPage);
    }

    public function render()
    {
        $substances = $this->getSubstances();

        return view('livewire.admin.drug-create-modal', compact('substances'));
    }
}
