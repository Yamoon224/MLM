<?php

namespace App\Repositories\Contracts;

interface MatrixClosureRepositoryInterface
{
    public function countDescendants(string $userId, int $depth): int;
}