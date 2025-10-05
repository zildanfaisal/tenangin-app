@extends('layouts.dashboard')
@section('title','Riwayat DASS-21')
@section('content')
<h1 class="text-xl font-semibold mb-4">Riwayat DASS-21</h1>
<form action="{{ route('dass21.start') }}" method="POST" class="mb-6">@csrf
    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Mulai Tes Baru</button>
</form>
@if($sessions->count())
<table class="w-full text-sm bg-white rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 text-left">Tanggal</th>
            <th class="p-2">D</th><th class="p-2">A</th><th class="p-2">S</th>
            <th class="p-2">Ringkasan</th>
            <th class="p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($sessions as $s)
        <tr class="border-t">
            <td class="p-2">{{ $s->completed_at? $s->completed_at->format('d M Y H:i'):'(Draft)' }}</td>
            <td class="p-2">{{ $s->depresi_skor }}</td>
            <td class="p-2">{{ $s->anxiety_skor }}</td>
            <td class="p-2">{{ $s->stres_skor }}</td>
            <td class="p-2">{{ $s->hasil_kelas }}</td>
            <td class="p-2">
                @if($s->completed_at)
                    <a class="text-indigo-600" href="{{ route('dass21.result',$s->id) }}">Detail</a>
                @else
                    <a class="text-blue-600" href="{{ route('dass21.form',$s->id) }}">Lanjutkan</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $sessions->links() }}</div>
@else
<p>Belum ada sesi.</p>
@endif
@endsection