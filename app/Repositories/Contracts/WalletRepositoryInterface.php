<?php

namespace App\Repositories\Contracts;

interface WalletRepositoryInterface
{
    public function findByUser(string $userId);
    public function createForUser(string $userId);
    public function credit(string $userId, float $amount, string $type, ?string $reference = null);
}