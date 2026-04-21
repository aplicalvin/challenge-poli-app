<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Poli;
use App\Models\Shift;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_dokter' => User::where('role', 'dokter')->count(),
            'total_apoteker' => User::where('role', 'apoteker')->count(),
            'total_kasir' => User::where('role', 'kasir')->count(),
        ];

        $polis = Poli::all();
        $shifts = Shift::all(); // Needed for doctor modal if we reuse it or for info

        return view('admin.dashboard', compact('stats', 'polis', 'shifts'));
    }
}
