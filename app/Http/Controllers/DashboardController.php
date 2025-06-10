<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Kalendars;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Http\Request;

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
