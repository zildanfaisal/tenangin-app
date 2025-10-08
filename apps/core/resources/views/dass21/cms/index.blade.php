@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Kelola DASS-21 Items</h1>
        <a href="{{ route('admin.dass21-items.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow">Tambah Item</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full border-collapse">
            <thead>
            <tr class="bg-gray-50 text-left text-sm font-medium text-gray-600">
                <th class="px-4 py-2 border-b">Urutan</th>
                <th class="px-4 py-2 border-b">Kode</th>
                <th class="px-4 py-2 border-b">Subskala</th>
                <th class="px-4 py-2 border-b">Pernyataan</th>
                <th class="px-4 py-2 border-b w-40">Aksi</th>
            </tr>
            </thead>
            <tbody class="text-sm">
            @forelse($items as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b align-top">{{ $item->urutan }}</td>
                    <td class="px-4 py-2 border-b align-top font-mono">{{ $item->kode }}</td>
                    <td class="px-4 py-2 border-b align-top capitalize">{{ $item->subskala }}</td>
                    <td class="px-4 py-2 border-b">{{ $item->pernyataan }}</td>
                    <td class="px-4 py-2 border-b">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.dass21-items.edit',$item) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.dass21-items.destroy',$item) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada item.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
