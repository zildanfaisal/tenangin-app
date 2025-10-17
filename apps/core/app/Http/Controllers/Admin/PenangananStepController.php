<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penanganan;
use App\Models\PenangananStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePenangananStepRequest;
use App\Http\Requests\UpdatePenangananStepRequest;

class PenangananStepController extends Controller
{
    public function index(Penanganan $penanganan)
    {
        $steps = $penanganan->steps()->get();
        return view('penanganan.steps.index', compact('penanganan','steps'));
    }

    public function create(Penanganan $penanganan)
    {
        $nextUrutan = ($penanganan->steps()->max('urutan') ?? 0) + 1;
        return view('penanganan.steps.create', compact('penanganan','nextUrutan'));
    }

    public function store(StorePenangananStepRequest $request, Penanganan $penanganan)
    {
        $data = $request->validated();
        $data['penanganan_id'] = $penanganan->id;
        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')->store('penanganan/steps','public');
        }
        PenangananStep::create($data);
        return redirect()->route('admin.penanganan.steps.index',$penanganan)->with('success','Step dibuat.');
    }

    public function edit(Penanganan $penanganan, PenangananStep $step)
    {
        return view('penanganan.steps.edit', compact('penanganan','step'));
    }

    public function update(UpdatePenangananStepRequest $request, Penanganan $penanganan, PenangananStep $step)
    {
        $data = $request->validated();
        if ($request->hasFile('video')) {
            if ($step->video_path) Storage::disk('public')->delete($step->video_path);
            $data['video_path'] = $request->file('video')->store('penanganan/steps','public');
        }
        $step->update($data);
        return redirect()->route('admin.penanganan.steps.index',$penanganan)->with('success','Step diperbarui.');
    }

    public function destroy(Penanganan $penanganan, PenangananStep $step)
    {
        if ($step->video_path) Storage::disk('public')->delete($step->video_path);
        $step->delete();
        return back()->with('success','Step dihapus.');
    }

    public function reorder(Request $request, Penanganan $penanganan)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:penanganan_steps,id',
            'orders.*.urutan' => 'required|integer|min:1',
        ]);
        foreach ($request->orders as $row) {
            PenangananStep::where('id',$row['id'])
                ->where('penanganan_id',$penanganan->id)
                ->update(['urutan'=>$row['urutan']]);
        }
        return back()->with('success','Urutan disimpan.');
    }
}
