<?php

namespace App\Http\Controllers;

use App\Model\Arsip;
use App\User;

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
    public function index()
    {

        $usercount = User::count();
        $suratmasukcount = Arsip::where('jenis_surat', '=', 'Masuk')->count();
        $suratkeluarcount = Arsip::where('jenis_surat', '=', 'Keluar')->count();

        return view('admin.home', compact('suratmasukcount', 'suratkeluarcount', 'usercount'));
    }
}
