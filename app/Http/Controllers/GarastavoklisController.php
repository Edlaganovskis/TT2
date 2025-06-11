<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Garastavoklis;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GarastavoklisController extends Controller {
    use AuthorizesRequests;
    public function create(){   
        return view('Garastavoklis.pievienot');
    }

    public function store(Request $request){
        $request->validate([
            'datums' => 'required|date',
            'Gstavoklis' => 'required|string',
            'sajutas' => 'nullable|string',
            'iemesls' => 'nullable|string',
            'piezimes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $kalendars = $user->kalendars()->firstOrCreate([
            'user_id' => $user->id
        ]);

        Garastavoklis::create([
            'datums' => $request->datums,
            'Gstavoklis' => $request->Gstavoklis,
            'sajutas' => $request->sajutas,
            'iemesls' => $request->iemesls,
            'piezimes' => $request->piezimes,
            'user_id'=> $user->id,
            'kalendars_id' => $kalendars->id,
        ]);
        return redirect()->route('MansKalendars')->with('success', 'Garastāvoklis pievienots!');
    }
    public function rediget(\App\Models\Garastavoklis $garastavoklis){
        return view('Garastavoklis.Rediget', compact('garastavoklis'));
    }
    public function atjaunot(Request $request, \App\Models\Garastavoklis $garastavoklis){
        $this->authorize('update', $garastavoklis);
        $validated = $request->validate([
            'datums' => 'required|date',
            'Gstavoklis' => 'required|string',
            'sajutas' => 'nullable|string',
            'iemesls' => 'nullable|string',
            'piezimes' => 'nullable|string',
        ]);
        $garastavoklis->update($validated);
        return redirect()->route('MansKalendars')->with('success', 'Garastāvokļa ieraksts atjaunots!');
    }
    public function dzest(\App\Models\Garastavoklis $garastavoklis){
        $garastavoklis->delete();
        return redirect()->route('MansKalendars')->with('success', 'Garastāvokļa ieraksts veiksmīgi dzēsts.');
    }
    public function MansKalendars()
    {
        $user = Auth::user();
        $kalendars = $user->kalendars()->first();

        $entries = collect(); // tukša kolekcija
        if ($kalendars) {     //
            $entries = Garastavoklis::where('user_id', $user->id)->where('kalendars_id', $kalendars->id)->get();
        }

        return view('MansKalendars', ['kalendars' => $kalendars, 'entries' => $entries,]);
    }
}