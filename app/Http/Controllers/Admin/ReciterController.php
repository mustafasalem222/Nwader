<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReciterRequest;
use App\Models\Sheikh;
use App\Models\Telaawah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReciterController extends Controller
{
    public function index(Request $request)
    {
        $query = Sheikh::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $reciters = $query->withCount('telaawat')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.reciters.index', compact('reciters'));
    }

    public function show(Sheikh $reciter)
    {
        $reciter->load(['telaawat' => fn($q) => $q->latest()]);

        return view('admin.reciters.show', compact('reciter'));
    }

    public function create()
    {
        return view('admin.reciters.create');
    }

    public function store(StoreReciterRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_url'] = Storage::url($request->file('image')->store('reciters', 'public'));
        }

        Sheikh::create($data);

        return redirect()->route('admin.reciters.index')
            ->with('success', 'تم إضافة الشيخ بنجاح');
    }

    public function edit(Sheikh $reciter)
    {
        $reciter->loadCount('telaawat');
        return view('admin.reciters.edit', compact('reciter'));
    }

    public function update(StoreReciterRequest $request, Sheikh $reciter)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_url'] = Storage::url($request->file('image')->store('reciters', 'public'));
        }

        $reciter->update($data);

        return redirect()->route('admin.reciters.index')
            ->with('success', 'تم تحديث الشيخ بنجاح');
    }

    public function destroy(Sheikh $reciter)
    {
        $reciter->delete();

        return redirect()->route('admin.reciters.index')
            ->with('success', 'تم حذف الشيخ بنجاح');
    }
}
