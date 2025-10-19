@extends('layouts.dashboard')
@section('title','Penanganan')
@section('content')
<h1 class="text-xl font-semibold mb-4">Penanganan</h1>

<div class="flex justify-between mb-4">
    <form class="flex gap-2" method="GET">
        <input name="search" value="{{ request('search') }}" placeholder="Cari..." class="border rounded px-2 py-1">
        <button class="px-3 py-1 bg-indigo-600 text-white rounded">Cari</button>
    </form>
    <a href="{{ route('admin.penanganan.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Tambah</a>
</div>
{{-- 
@if(session('success')) <div class="mb-3 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div> @endif
@if(session('error')) <div class="mb-3 p-2 bg-red-100 text-red-700 rounded">{{ session('error') }}</div> @endif --}}

<div class="overflow-x-auto bg-white shadow rounded">
<table class="w-full text-sm">
    <thead class="bg-gray-100 text-center">
        <tr>
            <th class="p-2">#</th>
            <th class="p-2 text-left">Nama</th>
            <th class="p-2">Status</th>
            <th class="p-2">Kelompok</th>
            <th class="p-2">Order</th>
            <th class="p-2">Aksi</th>
        </tr>
    </thead>
    <tbody class="text-center">
    @forelse($items as $it)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-2">{{ $it->id }}</td>
            <td class="p-2 text-left">
                <span class="font-medium">{{ $it->nama_penanganan }}</span><br>
                <span class="text-xs text-gray-500">{{ $it->slug }}</span>
            </td>
            <td class="p-2">
                <span class="px-2 py-1 rounded text-xs @if($it->status==='published') bg-green-100 text-green-700 @else bg-gray-200 text-gray-700 @endif">{{ ucfirst($it->status) }}</span>
            </td>
            <td class="p-2">
                <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded text-xs">
                    {{ is_array($it->kelompok) ? implode(', ', array_map('ucfirst', $it->kelompok)) : ucfirst($it->kelompok ?? '-') }}
                </span>
            </td>
            <td class="p-2">{{ $it->ordering }}</td>
            <td class="p-2 whitespace-nowrap">
                <a href="{{ route('admin.penanganan.edit',$it) }}" class="text-indigo-600">Edit</a>
                <a href="{{ route('admin.penanganan.steps.index',$it) }}" class="text-teal-600 ml-2">Steps</a>
                <form method="POST" action="{{ route('admin.penanganan.destroy',$it) }}" class="inline" onsubmit="return confirm('Hapus penanganan ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 ml-2">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="p-4 text-center text-gray-500">Belum ada data.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-4">{{ $items->links() }}</div>
@endsection
