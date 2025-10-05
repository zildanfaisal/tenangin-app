@extends('layouts.dashboard')
@section('title','DASS-21')
@section('content')
<h1 class="text-xl font-semibold mb-4">DASS-21 Assessment</h1>
@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
@endif
<form method="POST" action="{{ route('dass21.submit',$session->id) }}">
    @csrf
    <div class="space-y-6">
        @foreach($items as $i)
            <div class="p-4 border rounded bg-white">
                <p class="font-medium mb-2">{{ $i->urutan }}. {{ $i->pernyataan }}</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                    @foreach([0=>'Tidak Pernah',1=>'Kadang',2=>'Sering',3=>'Sangat Sering'] as $val=>$label)
                        <label class="inline-flex items-center space-x-2">
                            <input type="radio" name="responses[{{ $i->id }}]" value="{{ $val }}" @checked( (isset($existing[$i->id]) && (int)$existing[$i->id] === $val) ) required>
                            <span>{{ $val }} - {{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('dass21.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Submit</button>
    </div>
</form>
@endsection