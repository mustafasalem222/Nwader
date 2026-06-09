<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sheikh;
use App\Models\Telaawah;

class TelaawatTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sheikhId = '';

    protected $queryString = ['search', 'sheikhId'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSheikhId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Telaawah::with('sheikh');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhereHas('sheikh', fn($sq) => $sq->where('name', 'like', "%{$this->search}%"));
            });
        }

        if ($this->sheikhId) {
            $query->where('sheikh_id', $this->sheikhId);
        }

        $telaawat = $query->latest()->paginate(10);
        $sheikhs = Sheikh::orderBy('name')->get();

        return view('admin.livewire.telaawat-table', compact('telaawat', 'sheikhs'));
    }
}
