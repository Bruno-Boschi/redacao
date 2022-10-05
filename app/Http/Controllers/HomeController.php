<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function anyIndex()
    {
        if (Auth::user()->ativo == 0 || Auth::user()->ativo == 2) {
            Auth::logout();
            return redirect('/login')->with('mensagem', 'Usuário em avaliação ou Bloqueado.');
        }

        if (isset(Auth::user()->id)) {
            return redirect('/dashboard');
        } else {
            return redirect('/login');
        }
    }
}
