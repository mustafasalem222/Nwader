<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkStoreTelaawahRequest;
use App\Http\Requests\StoreTelaawahRequest;
use App\Models\Sheikh;
use App\Models\Telaawah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TelaawahController extends Controller
{
    public function index(Request $request)
    {
        $query = Telaawah::with('sheikh');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('sheikh', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($sheikhId = $request->get('sheikh_id')) {
            $query->where('sheikh_id', $sheikhId);
        }

        $telaawat = $query->latest()->paginate(10)->withQueryString();
        $sheikhs = Sheikh::orderBy('name')->get();

        return view('admin.telaawat.index', compact('telaawat', 'sheikhs'));
    }

    public function create()
    {
        $sheikhs = Sheikh::orderBy('name')->get();
        return view('admin.telaawat.create', compact('sheikhs'));
    }

    public function store(StoreTelaawahRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('audio')) {
            $data['audio_url'] = Storage::url($request->file('audio')->store('telaawat', 'public'));
        }

        Telaawah::create($data);

        return redirect()->route('admin.telaawat.index')
            ->with('success', 'تم إضافة التلاوة بنجاح');
    }

    public function edit(Telaawah $telaawat)
    {
        $telaawat->load('sheikh');
        $sheikhs = Sheikh::orderBy('name')->get();
        return view('admin.telaawat.edit', compact('telaawat', 'sheikhs'));
    }

    public function update(StoreTelaawahRequest $request, Telaawah $telaawat)
    {
        $data = $request->validated();

        if ($request->hasFile('audio')) {
            $data['audio_url'] = Storage::url($request->file('audio')->store('telaawat', 'public'));
        }

        $telaawat->update($data);

        return redirect()->route('admin.telaawat.index')
            ->with('success', 'تم تحديث التلاوة بنجاح');
    }

    public function destroy(Telaawah $telaawat)
    {
        $telaawat->delete();

        return redirect()->route('admin.telaawat.index')
            ->with('success', 'تم حذف التلاوة بنجاح');
    }

    public function bulkUpload()
    {
        $sheikhs = Sheikh::orderBy('name')->get();
        return view('admin.telaawat.bulk-upload', compact('sheikhs'));
    }

    public function bulkStore(BulkStoreTelaawahRequest $request)
    {
        $data = $request->validated();
        $created = [];

        foreach ($request->file('audios') as $file) {
            $telaawah = Telaawah::create([
                'sheikh_id' => $data['sheikh_id'],
                'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'audio_url' => Storage::url($file->store('telaawat', 'public')),
            ]);

            $created[] = $telaawah;
        }

        return redirect()->route('admin.telaawat.index')
            ->with('success', 'تم رفع ' . count($created) . ' تلاوة بنجاح');
    }
}
