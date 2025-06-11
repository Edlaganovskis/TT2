<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user(); //Lietotaja dati
        $kalendars = $user->kalendars; //Viens kalendars vienam lietotajam
        $entries = $kalendars
            ? $kalendars->garastavoklis()->orderByDesc('datums')->get()
            : collect();

        return view('Dashboard', compact('kalendars', 'entries'));
    }
}
