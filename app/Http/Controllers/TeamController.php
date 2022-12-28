<?php

namespace App\Http\Controllers;
use App\Models\Team;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index() {
        $data = Team::where('league', 'NCAA')->where('sport', 'basketball')->get();

        return view('teamlogos', compact('data'));
    }
}
