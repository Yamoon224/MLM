<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class MatrixClosureService
{
    /**
     * Insère un nouveau noeud dans la closure table
     */
    public function insertNode(User $user, User $parent): void
    {
        // 1. Lui-même (depth 0)
        DB::table('matrix_closure')->insert([
            'ancestor_id'   => $parent->id,
            'descendant_id' => $user->id,
            'depth'         => 1,
        ]);

        // 2. Tous les ancêtres du parent
        $ancestors = DB::table('matrix_closure')
            ->where('descendant_id', $parent->id)
            ->get();

        foreach ($ancestors as $ancestor) {
            DB::table('matrix_closure')->insert([
                'ancestor_id'   => $ancestor->ancestor_id,
                'descendant_id' => $user->id,
                'depth'         => $ancestor->depth + 1,
            ]);
        }
    }
}