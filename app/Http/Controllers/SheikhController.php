<?php

namespace App\Http\Controllers;

use App\Models\Sheikh;
use App\Models\Telaawah;

class SheikhController extends Controller
{
    public function index()
    {
        $sheikhs = Sheikh::with('telaawat')->get();
        $telaawat = Telaawah::with('sheikh')->latest()->get();
        $totalSheikhs = Sheikh::count();
        $totalTelaawat = Telaawah::count();

        return view('welcome', compact('sheikhs', 'telaawat', 'totalSheikhs', 'totalTelaawat'));
    }
}
