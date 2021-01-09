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
        'drugCreated' => 'updateList',
        'drugUpdated' => 'updateList'
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

    public function openCreateModal()
    {
        $this->emit('openDrugCreateModal');
    }

    public function openUpdateModal($id)
    {
        $this->emit('openDrugUpdateModal', $id);
    }

    public function updateList()
    {
        $this->render();
    }

    public function delete(Drug $item)
    {
        $item->delete();

        $this->resetPage();
    }

    public function render()
    {
        $items = $this->getItems();

        return view('livewire.admin.drugs-control', compact('items'));
    }
}
