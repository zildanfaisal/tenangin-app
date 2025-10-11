<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Suara;
use Illuminate\Support\Facades\Auth;

class AnalisisController extends Controller
{
    public function show(Analisis $analisis)
    {
        if ($analisis->user_id !== Auth::id()) abort(403);
        return response()->json($analisis);
    }

    public function bySuara(Suara $suara)
    {
        if ($suara->user_id !== Auth::id()) abort(403);
        $list = Analisis::where('suara_id', $suara->id)->orderByDesc('id')->get();
        return response()->json($list);
    }
}
