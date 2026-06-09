<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sheikh;

class RecitersTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Sheikh::withCount('telaawat');

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        $reciters = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.livewire.reciters-table', compact('reciters'));
    }
}
