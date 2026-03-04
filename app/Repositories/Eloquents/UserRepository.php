<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function paginate(int $perPage = 15)
    {
        return User::paginate($perPage);
    }

    public function find(string $id): ?User
    {
        return User::find($id);
    }

    public function findByReferralCode(string $code): ?User
    {
        return User::where('referral_code', $code)->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(string $id, array $data): User
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    public function delete(string $id): bool
    {
        return User::destroy($id);
    }


    public function incrementMatrixChildrenCount(string $userId): void
    {
        $user = User::where('id', $userId)
            ->lockForUpdate()
            ->firstOrFail();

        $user->increment('matrix_children_count');
    }
}