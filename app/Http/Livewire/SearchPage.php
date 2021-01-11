<?php

namespace App\Http\Livewire;

use App\Models\Drug;
use App\Models\Substance;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $substances;
    public $selectedSubstances = [];
    public $selectedKey;

    public $completeMatch = false;

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

            $res = Drug::with('')->withCount(['matches' => Drug::substancesSearch($ids), 'substances'])
                ->having('matches_count', '=' ,'substance_count')
//                ->whereHas('substances', Drug::substancesSearch($ids))
//                ->orderByDesc('matches_count')
                ->get();

            //                ->having('matches_count', '>', 1)

//            $haveSameCount = false;
//            foreach ($res as $item) {
//                if ($item->matches_count == $item->substances_count) {
//                    $haveSameCount = true;
//                    break;
//                }
//            }
//
//            if ($haveSameCount) {
//                foreach ($res as $key => $item) {
//                    if ($item->matches_count != $item->substances_count) {
//                        unset($res[$key]);
//                    }
//                }
//            }

            $res = $this->paginate($res);
        }

        return $res;
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function render()
    {
        $drugs = $this->getDrugs();

        return view('livewire.search-page', compact('drugs'));
    }
}
