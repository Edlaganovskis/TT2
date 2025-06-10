<?php

namespace App\Http\Controllers;
use App\Models\Kalendars;
use Illuminate\Support\Facades\Auth;

class KalendarsController extends Controller
{
    public function Publisks(Kalendars $kalendars)  { // Kalendāra Publisks/privāts var mainīt tikai autors
        $user = Auth::user();
        if (!$user || $kalendars->user_id !== $user->id) {
            abort(1);
        }
        $kalendars->publisks = !$kalendars->publisks;
        $kalendars->save();

    return back();
    }
    public function index() { // Atlasa tikai publiskos kalendārus
        $kalendari = Kalendars::where('publisks', true)->with(['user', 'garastavoklis'])->get();
        $kalendaruEntries = [];
        foreach ($kalendari as $kalendars) {
            $kalendaruEntries[$kalendars->id] = $kalendars->garastavoklis->map(function($g) {
                return [
                    'title' => $g->Gstavoklis,
                    'start' => $g->datums,
                    'description' => $g->iemesls,
                    'extendedProps' => [
                        'id' => $g->id,
                        'piezimes' => $g->piezimes,
                    ]
                ];
            });
        }
    return view('publiskiekalendari', compact('kalendari', 'kalendaruEntries'));
    }
    public function destroy(Kalendars $kalendars){ //Dzēšana
        $kalendars->delete();
    return;
    }
}
