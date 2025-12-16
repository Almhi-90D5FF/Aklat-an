<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sections = Section::all();

        return view('dashboard', compact('sections'));
    }
}
