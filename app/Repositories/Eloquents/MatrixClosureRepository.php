<?php

namespace App\Repositories\Eloquents;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\MatrixClosureRepositoryInterface;

class MatrixClosureRepository implements MatrixClosureRepositoryInterface
{
    public function countDescendants(string $userId, int $depth): int
    {
        return DB::table('matrix_closure')
            ->where('ancestor_id', $userId)
            ->where('depth', $depth)
            ->count();
    }
}