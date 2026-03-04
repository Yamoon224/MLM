<?php

namespace App\Services;

use Exception;
use App\Models\User;

class MatrixPlacementService
{
    const MAX_CHILDREN = 5;
    const MAX_LEVEL = 5;

    public function findAvailableParent(User $root): User
    {
        $queue = collect([$root]);

        while ($queue->isNotEmpty()) {

            $current = $queue->shift();

            $parent = User::where('id', $current->id)
                ->where('matrix_children_count', '<', self::MAX_CHILDREN)
                ->where('matrix_level', '<', self::MAX_LEVEL)
                ->lockForUpdate()
                ->first();

            if ($parent) {
                return $parent;
            }

            $children = User::where('matrix_parent_id', $current->id)->get();
            $queue = $queue->merge($children);
        }

        throw new Exception('Matrix full');
    }
}