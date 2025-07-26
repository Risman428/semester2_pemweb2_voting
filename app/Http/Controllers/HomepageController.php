<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $kandidats = Kandidat::withCount('votings')->get();
        return view('homepage', compact('kandidats'));
    }
}
