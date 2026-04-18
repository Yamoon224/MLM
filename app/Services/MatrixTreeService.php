<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class MatrixTreeService
{
    const MAX_DEPTH = 5;

    /**
     * Construit un arbre récursif pour un utilisateur donné jusqu'à MAX_DEPTH niveaux.
     * Retourne un tableau structuré : ['user' => User, 'children' => [...]]
     */
    public function buildTree(User $root, int $currentDepth = 0): array
    {
        $node = [
            'user'     => $root,
            'depth'    => $currentDepth,
            'children' => [],
        ];

        if ($currentDepth >= self::MAX_DEPTH) {
            return $node;
        }

        $children = User::where('matrix_parent_id', $root->id)
            ->orderBy('created_at')
            ->get();

        foreach ($children as $child) {
            $node['children'][] = $this->buildTree($child, $currentDepth + 1);
        }

        return $node;
    }

    /**
     * Statistiques par niveau pour un utilisateur racine.
     * Retourne un tableau [depth => count]
     */
    public function statsByLevel(User $root): array
    {
        $rows = DB::table('matrix_closure')
            ->where('ancestor_id', $root->id)
            ->whereBetween('depth', [1, self::MAX_DEPTH])
            ->selectRaw('depth, count(*) as total')
            ->groupBy('depth')
            ->orderBy('depth')
            ->get();

        $stats = [];
        for ($i = 1; $i <= self::MAX_DEPTH; $i++) {
            $stats[$i] = 0;
        }

        foreach ($rows as $row) {
            $stats[$row->depth] = (int) $row->total;
        }

        return $stats;
    }
}
