<?php

namespace App\Http\Livewire\Admin;

use App\Models\Drug;
use App\Models\Substance;
use Livewire\Component;

class DrugUpdateModal extends Component
{
    protected $listeners = ['openDrugUpdateModal' => 'open'];

    protected $rules = [
        'name' => 'required|min:3|max:255'
    ];

    public $displayModal;

    public $name;
    public $item;

    public $step;
    public $values = [];
    public $perPage = 0;



    public function open(Drug $item)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->displayModal = true;

        $this->name = $item->name;
        $this->item = $item;

        $ids = $item->substances()->pluck('id');

        foreach ($ids as $id) {
            $this->values[$id] = true;
        }

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

        $this->item->update($validatedData);

        $this->item->substances()->sync(array_keys(array_filter($this->values)));

        $this->close();

        $this->emit('drugUpdated');
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

        return view('livewire.admin.drug-update-modal', compact('substances'));
    }
}
