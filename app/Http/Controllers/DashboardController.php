<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        $user = Auth::user();

        $perPage = $request->input('per_page', 10);

        $descendants = $user->descendants()
            ->select('users.*', 'matrix_closure.depth') // IMPORTANT
            ->orderBy('matrix_closure.depth')
            ->orderBy('users.created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $referral_bonus = $user->bonus();
        $level_bonus = $user->bonus('LEVEL_BONUS');

        return view('dashboard', compact('descendants', 'referral_bonus', 'level_bonus'));
    }
}
