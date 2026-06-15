<?php

namespace App\Http\Controllers;

use App\Models\Telaawah;

class TelaawahController extends Controller
{
    public function show(Telaawah $telaawah)
    {
        $telaawah->load('sheikh');
        $telaawah->sheikh_name = $telaawah->sheikh->name;
        $telaawah->download_url = route('telaawat.download', $telaawah);
        $telaawah->share_url = route('home') . '?telaawah=' . $telaawah->id;

        $moreFromSheikh = Telaawah::where('sheikh_id', $telaawah->sheikh_id)
            ->where('id', '!=', $telaawah->id)
            ->with('sheikh:id,name')
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($t) {
                $t->sheikh_name = $t->sheikh->name;
                $t->download_url = route('telaawat.download', $t);
                $t->share_url = route('home') . '?telaawah=' . $t->id;
                return $t;
            });

        return view('telaawah.show', compact('telaawah', 'moreFromSheikh'));
    }
}
