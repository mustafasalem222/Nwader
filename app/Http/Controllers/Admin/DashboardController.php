<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sheikh;
use App\Models\Telaawah;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReciters = Sheikh::count();
        $totalTelaawat = Telaawah::count();

        $latestTelaawat = Telaawah::with('sheikh')
            ->latest()
            ->take(5)
            ->get();

        $topReciters = Sheikh::withCount('telaawat')
            ->orderBy('telaawat_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalReciters',
            'totalTelaawat',
            'latestTelaawat',
            'topReciters'
        ));
    }
}
