<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
class welcomeController extends Controller
{
    public function index() { // atgriež pēdējo reģistrēto garastāvokli
        $user = Auth::user();
        $PedejaisGstavoklis = null;
        if ($user) {
            $PedejaisGstavoklis = $user->Garastavoklis()->orderBy('created_at', 'desc')->first();
        }
        return view('welcome', [
            'PedejaisGstavoklis' => $PedejaisGstavoklis?->Gstavoklis,
        ]);
    }
}