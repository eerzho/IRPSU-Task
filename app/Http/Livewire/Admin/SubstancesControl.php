<?php

namespace App\Http\Livewire\Admin;

use App\Models\Substance;
use Livewire\Component;
use Livewire\WithPagination;

class SubstancesControl extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'substanceCreated' => 'updateList',
        'substanceUpdated' => 'updateList',
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
        $query = Substance::query();

        if ($this->search)
            $query->where('name', 'LIKE', "{$this->search}%");

        $items = $query->withCount('drugs')->paginate();

        return $items;
    }

    public function openCreateModal()
    {
        $this->emit('openSubstanceCreateModal');
    }

    public function openUpdateModal($id)
    {
        $this->emit('openSubstanceUpdateModal', $id);
    }

    public function updateList()
    {
        $this->render();
    }

    public function delete($id)
    {
        $item = Substance::findOrFail($id);

        $item->delete();

        $this->resetPage();

        $this->render();
    }

    public function changeVisible($id)
    {
        $item = Substance::findOrFail($id);

        $item->update([
            'visible' => !$item->visible
        ]);
    }

    public function render()
    {
        $items = $this->getItems();

        return view('livewire.admin.substances-control', compact('items'));
    }
}
