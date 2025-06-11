<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class MansKalendarsController extends Controller
{
    public function index(){
        $user = Auth::user(); //Lietotaja dati
        $kalendars = $user->kalendars; //Viens kalendars vienam lietotajam
        $entries = $kalendars
            ? $kalendars->garastavoklis()->orderByDesc('datums')->get()
            : collect();

        return view('MansKalendars', compact('kalendars', 'entries'));
    }
}
