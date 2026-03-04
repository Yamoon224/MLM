<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Repositories\Contracts\MatrixClosureRepositoryInterface;

class BonusService
{
    const MAX_LEVEL = 5;

    public function __construct(
        private WalletRepositoryInterface $wallets,
        private MatrixClosureRepositoryInterface $closure
    ) {}

    public function handleRegistrationBonus(User $sponsor, User $newUser)
    {
        $this->wallets->credit(
            $sponsor->id,
            5000,
            'REFERRAL_BONUS',
            'REF_'.$newUser->id
        );

        $this->checkLevelCompletion($sponsor);
    }

    public function handleRegistrationBonusById(string $sponsorId, string $newUserId)
    {
        $this->wallets->credit(
            $sponsorId,
            5000,
            'REFERRAL_BONUS',
            'REF_'.$newUserId
        );

        $level = User::find($newUserId)->matrix_level;

        $expected = pow(5, $level);

        $count = $this->closure
            ->countDescendants($sponsorId, $level);

        if ($count == $expected) {

            $this->wallets->credit(
                $sponsorId,
                $this->levelAmount($level),
                'LEVEL_BONUS',
                'LEVEL_'.$level.'_'.$sponsorId
            );
        }
    }

    private function checkLevelCompletion(User $user)
    {
        for ($level = 1; $level <= self::MAX_LEVEL; $level++) {

            $expected = pow(5, $level);

            $count = $this->closure
                ->countDescendants($user->id, $level);

            if ($count == $expected) {

                $this->wallets->credit(
                    $user->id,
                    $this->levelAmount($level),
                    'LEVEL_BONUS',
                    'LEVEL_'.$level
                );
            }
        }
    }

    private function levelAmount(int $level): float
    {
        return match($level) {
            1 => 10000,
            2 => 25000,
            3 => 50000,
            4 => 100000,
            5 => 250000,
        };
    }
}