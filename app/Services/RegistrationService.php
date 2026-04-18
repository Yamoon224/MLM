<?php
namespace App\Services;

use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\MatrixPlacementService;
use App\Services\MatrixClosureService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class RegistrationService
{
    public function __construct(
        private UserRepositoryInterface $users,
        private WalletRepositoryInterface $wallets,
        private BonusService $bonusService,
        private MatrixPlacementService $placementService,
        private MatrixClosureService $closureService
    ) {}

    public function register(array $data, string $referralCode)
    {
        return DB::transaction(function () use ($data, $referralCode) {

            $sponsor = $this->users->findByReferralCode($referralCode);

            if (!$sponsor) {
                throw new Exception("Invalid referral code");
            }

            $parent = $this->placementService
                ->findAvailableParent($sponsor);
                
            $data['referral_code'] = strtoupper(Str::random(8));
            $user = $this->users->create([
                ...$data,
                'sponsor_id' => $sponsor->id,
                'matrix_parent_id' => $parent->id,
                'matrix_level' => $parent->matrix_level + 1,
                'expires_at' => now()->addYear(),
            ]);

            $this->users->incrementMatrixChildrenCount($parent->id);

            $this->wallets->createForUser($user->id);

            $this->closureService->insertNode($user, $parent);

            $this->bonusService
                ->handleRegistrationBonus($sponsor, $user);

            return $user;
        });
    }
}