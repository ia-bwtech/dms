<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sport;

class SportController extends Controller
{
    public function index() {
        return sport::all();
    }
}
