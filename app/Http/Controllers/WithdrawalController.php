<?php

namespace App\Http\Controllers;

use App\Models\WithdrawalRequest;
use App\Services\WithdrawalService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class WithdrawalController extends Controller
{
    public function __construct(private WithdrawalService $service) {}

    /**
     * Affiche le formulaire de retrait et la dernière demande en cours.
     */
    public function create()
    {
        $user    = auth()->user();
        $wallet  = $user->wallet;
        $pending = WithdrawalRequest::where('user_id', $user->id)->pending()->first();
        $recent  = WithdrawalRequest::where('user_id', $user->id)
                        ->orderByDesc('created_at')
                        ->take(5)
                        ->get();

        return view('wallet.withdraw', compact('wallet', 'pending', 'recent'));
    }

    /**
     * Enregistre une demande de retrait.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount'       => ['required', 'numeric', 'min:' . WithdrawalService::MIN_AMOUNT],
            'method'       => ['required', Rule::in(WithdrawalService::METHODS)],
            'phone_number' => ['required', 'string', 'max:20'],
        ]);

        try {
            $this->service->request(
                auth()->user(),
                (float) $request->amount,
                $request->method,
                $request->phone_number
            );
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('wallet.withdraw')
            ->with('success', __('locale.withdrawal_submitted'));
    }

    /**
     * Historique des retraits de l'utilisateur.
     */
    public function history()
    {
        $withdrawals = WithdrawalRequest::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('wallet.history', compact('withdrawals'));
    }
}
