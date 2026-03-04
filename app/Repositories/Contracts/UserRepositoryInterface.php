<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function paginate(int $perPage = 15);
    public function find(string $id): ?User;
    public function findByReferralCode(string $code): ?User;
    public function create(array $data): User;
    public function update(string $id, array $data): User;
    public function delete(string $id): bool;

    public function incrementMatrixChildrenCount(string $userId): void;
}