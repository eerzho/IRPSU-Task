<?php

namespace App\Http\Livewire;

use App\Models\Drug;
use App\Models\Substance;
use Livewire\Component;
use Livewire\WithPagination;

class SearchPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $substances;
    public $selectedSubstances = [];
    public $selectedKey;

    public function mount()
    {
        $this->substances = Substance::where('visible', true)->get()->toArray();
    }

    public function updatedSelectedKey()
    {
        $this->resetPage();

        $this->selectedSubstances[$this->selectedKey] = $this->substances[$this->selectedKey];

        unset($this->substances[$this->selectedKey]);

        $this->selectedKey = null;

        $this->getDrugs();
    }

    public function delete($key)
    {
        $this->resetPage();

        $this->substances[$key] = $this->selectedSubstances[$key];

        unset($this->selectedSubstances[$key]);

        $this->getDrugs();
    }


    private function getDrugs()
    {
        $res = [];

        if (count($this->selectedSubstances) > 1) {

            $ids = [];
            foreach ($this->selectedSubstances as $substance)
                $ids[] = $substance['id'];

            $query = Drug::with(['substances' => Drug::substancesSearch($ids)])
                ->withCount(['substances as matches_count' => Drug::substancesSearch($ids), 'substances'])
                ->whereHas('substances', Drug::substancesSearch($ids));

            $cQuery = clone ($query);

            $res = $cQuery->havingRaw('substances_count = matches_count && matches_count = ' . count($ids))->paginate();

            if (!count($res)) {
                $res = $query->havingRaw('matches_count > 1')->orderByDesc('matches_count')->paginate();
            }
        }

        return $res;
    }

    public function render()
    {
        $drugs = $this->getDrugs();

        return view('livewire.search-page', compact('drugs'));
    }
}
