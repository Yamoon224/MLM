<?php

namespace App\Services;

use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Validation\ValidationException;

class WithdrawalService
{
    /** Montant minimum de retrait en FCFA */
    public const MIN_AMOUNT = 5000;

    /** Méthodes de paiement acceptées */
    public const METHODS = ['MTN', 'ORANGE', 'WAVE', 'MOOV'];

    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ) {}

    /**
     * Soumet une demande de retrait.
     * Vérifie : compte actif, solde suffisant, pas de demande PENDING en cours, montant minimum.
     */
    public function request(User $user, float $amount, string $method, string $phone): WithdrawalRequest
    {
        // 1. Compte actif
        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'amount' => __('locale.withdrawal_account_inactive'),
            ]);
        }

        // 2. Montant minimum
        if ($amount < self::MIN_AMOUNT) {
            throw ValidationException::withMessages([
                'amount' => __('locale.withdrawal_min_amount', ['min' => xaf(self::MIN_AMOUNT)]),
            ]);
        }

        // 3. Solde suffisant
        $wallet = $this->walletRepository->findByUser($user->id);
        if (! $wallet || $wallet->balance < $amount) {
            throw ValidationException::withMessages([
                'amount' => __('locale.withdrawal_insufficient_balance'),
            ]);
        }

        // 4. Pas de demande déjà en cours
        $hasPending = WithdrawalRequest::where('user_id', $user->id)
            ->pending()
            ->exists();

        if ($hasPending) {
            throw ValidationException::withMessages([
                'amount' => __('locale.withdrawal_pending_exists'),
            ]);
        }

        return WithdrawalRequest::create([
            'user_id'      => $user->id,
            'amount'       => $amount,
            'method'       => $method,
            'phone_number' => $phone,
            'status'       => 'PENDING',
        ]);
    }

    /**
     * Approuve un retrait : débite le wallet et marque APPROVED.
     */
    public function approve(WithdrawalRequest $withdrawal, int $adminId): void
    {
        if (! $withdrawal->isPending()) {
            throw new \RuntimeException('Seules les demandes en attente peuvent être approuvées.');
        }

        $this->walletRepository->debit(
            (string) $withdrawal->user_id,
            $withdrawal->amount,
            'WITHDRAWAL',
            'WITHDRAWAL-' . $withdrawal->id
        );

        $withdrawal->update([
            'status'       => 'APPROVED',
            'processed_by' => $adminId,
            'processed_at' => now(),
        ]);
    }

    /**
     * Rejette un retrait sans toucher au solde.
     */
    public function reject(WithdrawalRequest $withdrawal, int $adminId, ?string $note = null): void
    {
        if (! $withdrawal->isPending()) {
            throw new \RuntimeException('Seules les demandes en attente peuvent être rejetées.');
        }

        $withdrawal->update([
            'status'       => 'REJECTED',
            'processed_by' => $adminId,
            'processed_at' => now(),
            'admin_note'   => $note,
        ]);
    }
}
