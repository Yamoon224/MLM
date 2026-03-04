<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();

        // Wallet
        $wallet = $user->wallet;
        $balance = $wallet ? $wallet->balance : 0;

        // Filleuls directs (niveau 1)
        $level1 = $user->matrix_children()->get(['id','full_name','email','phone','matrix_level']);

        // Filleuls par niveau (jusqu'à 5)
        $levels = [];
        for ($lvl = 1; $lvl <= 5; $lvl++) {
            $usersAtLevel = $user->descendants()
                ->where('matrix_closure.depth', $lvl)
                ->get(['users.id','users.full_name','users.email','users.phone','users.matrix_level']);
            $levels[$lvl] = $usersAtLevel;
        }

        // Gains
        $transactions = $user->wallet_transactions()->get(['type','amount','reference','created_at']);

        return response()->json([
            'success' => true,
            'data' => [
                'wallet' => [
                    'balance' => $balance,
                    'transactions' => $transactions
                ],
                'direct_filleuls' => $level1,
                'matrix' => $levels,
            ]
        ]);
    }
}