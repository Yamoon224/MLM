<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user    = Auth::user();
        $perPage = $request->input('per_page', 10);

        // Derniers descendants paginés
        $descendants = $user->descendants()
            ->select('users.*', 'matrix_closure.depth')
            ->orderBy('matrix_closure.depth')
            ->orderBy('users.created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        // Bonus
        $referral_bonus = $user->bonus('REFERRAL_BONUS');
        $level_bonus    = $user->bonus('LEVEL_BONUS');
        $total_bonus    = $referral_bonus + $level_bonus;

        // Statistiques réseau par niveau (1 → 5)
        $network_stats = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = DB::table('matrix_closure')
                ->where('ancestor_id', $user->id)
                ->where('depth', $i)
                ->count();
            $max   = pow(5, $i);
            $network_stats[$i] = [
                'count'   => $count,
                'max'     => $max,
                'percent' => $max > 0 ? min(100, round($count / $max * 100)) : 0,
            ];
        }

        // Totaux réseau
        $total_members  = $user->descendants()->count();
        $direct_members = $user->matrix_children()->count(); // niveau 1

        // Dernières transactions
        $recent_transactions = $user->wallet_transactions()
            ->latest()
            ->limit(5)
            ->get();

        // Bonus par niveau (LEVEL_BONUS déjà perçus)
        $level_bonuses_earned = $user->wallet_transactions()
            ->where('type', 'LEVEL_BONUS')
            ->get();
        
        $total_bonus    = $referral_bonus + $level_bonus;

        // Statistiques réseau par niveau (1 → 5)
        $network_stats = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = DB::table('matrix_closure')
                ->where('ancestor_id', $user->id)
                ->where('depth', $i)
                ->count();
            $max   = pow(5, $i);
            $network_stats[$i] = [
                'count'   => $count,
                'max'     => $max,
                'percent' => $max > 0 ? min(100, round($count / $max * 100)) : 0,
            ];
        }

        // Totaux réseau
        $total_members  = $user->descendants()->count();
        $direct_members = $user->matrix_children()->count(); // niveau 1

        // Dernières transactions
        $recent_transactions = $user->wallet_transactions()
            ->latest()
            ->limit(5)
            ->get();

        // Bonus par niveau (LEVEL_BONUS déjà perçus)
        $level_bonuses_earned = $user->wallet_transactions()
            ->where('type', 'LEVEL_BONUS')
            ->get();

        return view('dashboard', compact(
            'descendants',
            'referral_bonus',
            'level_bonus',
            'total_bonus',
            'network_stats',
            'total_members',
            'direct_members',
            'recent_transactions',
            'level_bonuses_earned',
        ));
    }
}
