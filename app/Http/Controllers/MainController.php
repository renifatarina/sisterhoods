<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        return view('layouts.home');
    }

    public function visimisi()
    {
        return view('layouts.visimisi');
    }

    public function article()
    {
        return view('layouts.article');
    }

    public function events()
    {
        return view('layouts.events');
    }

    public function suara()
    {
        return view('layouts.suara-wanita');
    }

    public function member()
    {
        return view('layouts.member');
    }
    
    public function inputsw()
    {
        return view('layouts.inputsw');
    }
}
