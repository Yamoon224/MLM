<?php

namespace App\Http\Controllers;

use App\Models\AccountRenewal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AccountRenewalController extends Controller
{
    /** Montant de la réactivation en FCFA */
    public const RENEWAL_AMOUNT = 5000;

    public function show(): View
    {
        return view('account.expired', [
            'user'   => auth()->user(),
            'amount' => self::RENEWAL_AMOUNT,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_reference' => ['required', 'string', 'max:100'],
        ]);

        $user = $request->user();

        DB::transaction(function () use ($user, $request) {
            $newExpiry = now()->addYear();

            AccountRenewal::create([
                'user_id'           => $user->id,
                'amount'            => self::RENEWAL_AMOUNT,
                'payment_reference' => $request->payment_reference,
                'status'            => 'confirmed',
                'confirmed_at'      => now(),
                'expires_at'        => $newExpiry,
            ]);

            $user->update([
                'is_active'  => true,
                'expires_at' => $newExpiry,
            ]);
        });

        return redirect()->route('dashboard')
            ->with('success', __('locale.account_renewed'));
    }
}
