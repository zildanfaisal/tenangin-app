<?php

namespace App\Http\Controllers;

use App\Models\Dass21Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dass21ItemController extends Controller
{
    public function index()
    {
        $items = Dass21Item::orderBy('urutan')->paginate(25);
        return view('dass21.cms.index', compact('items'));
    }

    public function create()
    {
        return view('dass21.cms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|string|max:10|unique:dass21_items,kode',
            'pernyataan' => 'required|string',
            'subskala' => 'required|in:depresi,anxiety,stres',
            'urutan' => 'required|integer|min:1|max:255|unique:dass21_items,urutan',
        ]);
        Dass21Item::create($data);
        return redirect()->route('admin.dass21-items.index')->with('success','Item berhasil dibuat');
    }

    public function edit(Dass21Item $dass21_item)
    {
        return view('dass21.cms.edit', ['item' => $dass21_item]);
    }

    public function update(Request $request, Dass21Item $dass21_item)
    {
        $data = $request->validate([
            'kode' => 'required|string|max:10|unique:dass21_items,kode,' . $dass21_item->id,
            'pernyataan' => 'required|string',
            'subskala' => 'required|in:depresi,anxiety,stres',
            'urutan' => 'required|integer|min:1|max:255|unique:dass21_items,urutan,' . $dass21_item->id,
        ]);
        $dass21_item->update($data);
        return redirect()->route('admin.dass21-items.index')->with('success','Item berhasil diperbarui');
    }

    public function destroy(Dass21Item $dass21_item)
    {
        DB::transaction(function () use ($dass21_item) {
            // Pastikan tidak ada response terkait? (Boleh dibiarkan cascade by foreign key jika di-set)
            $dass21_item->delete();
        });
        return redirect()->route('admin.dass21-items.index')->with('success','Item berhasil dihapus');
    }
}
