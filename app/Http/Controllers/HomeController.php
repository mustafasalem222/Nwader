<?php

namespace App\Http\Controllers;

use App\Models\Sheikh;
use App\Models\Telaawah;

class HomeController extends Controller
{
    public function index()
    {
        $sheikhs = Sheikh::withCount('telaawat')->get();

        $telaawat = Telaawah::with('sheikh:id,name')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($t) {
                $t->sheikh_name = $t->sheikh->name;
                $t->download_url = route('telaawat.download', $t);
                $t->share_url = route('home') . '?telaawah=' . $t->id;
                $t->show_url = route('telaawah.show', $t);
                return $t;
            });

        $totalSheikhs = $sheikhs->count();
        $totalTelaawat = Telaawah::count();

        return view('welcome', compact('sheikhs', 'telaawat', 'totalSheikhs', 'totalTelaawat'));
    }
}
