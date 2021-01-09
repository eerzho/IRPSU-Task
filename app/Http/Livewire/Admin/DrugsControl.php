<?php

namespace App\Http\Livewire\Admin;

use App\Models\Drug;
use App\Models\Substance;
use Livewire\Component;
use Livewire\WithPagination;

class DrugsControl extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'drugCreated' => 'created',
    ];

    public $search;

    public function mount()
    {

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getItems()
    {
        $query = Drug::query();

        if ($this->search)
            $query->where('name', 'LIKE', "{$this->search}%");

        $items = $query->withCount('substances')->paginate();

        return $items;
    }

    public function openModal()
    {
        $this->emit('openDrugCreateModal');
    }

    public function created()
    {
        $this->render();
    }

    public function delete($id)
    {
        $item = Drug::findOrFail($id);

        $item->delete();

        $this->resetPage();

        $this->render();
    }

    public function render()
    {
        $items = $this->getItems();

        return view('livewire.admin.drugs-control', compact('items'));
    }
}
