<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\league;

class LeagueController extends Controller
{
    public function index() {
        $data = league::with('sport')->orderBy('sport_id')->get();

        foreach($data as $item) {
            if($item->name == 'NCAA' && $item->sport->name == 'football') {
                $item->name = 'NCAAF';
            }
            else if($item->name == 'NCAA' && $item->sport->name == 'basketball') {
                $item->name = 'NCAAB';
            }
        }

        return $data;
    }
}
