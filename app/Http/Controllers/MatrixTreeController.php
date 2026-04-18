<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MatrixTreeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatrixTreeController extends Controller
{
    public function __construct(protected MatrixTreeService $treeService)
    {
    }

    /**
     * Affiche l'arbre généalogique de la matrice de l'utilisateur connecté.
     */
    public function index()
    {
        /** @var User $user */
        $user  = Auth::user();
        $tree  = $this->treeService->buildTree($user);
        $stats = $this->treeService->statsByLevel($user);

        return view('matrix.tree', compact('tree', 'stats', 'user'));
    }

    /**
     * Affiche l'arbre à partir d'un nœud spécifique (pour Admin ou navigation).
     * On s'assure que le nœud demandé est bien un descendant de l'utilisateur connecté.
     */
    public function show(int $userId)
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        // Vérifie que userId est un descendant ou soi-même
        $isDescendant = $authUser->id === $userId
            || \Illuminate\Support\Facades\DB::table('matrix_closure')
                ->where('ancestor_id', $authUser->id)
                ->where('descendant_id', $userId)
                ->exists();

        abort_unless($isDescendant, 403);

        $node  = User::findOrFail($userId);
        $tree  = $this->treeService->buildTree($node);
        $stats = $this->treeService->statsByLevel($node);

        return view('matrix.tree', compact('tree', 'stats', 'user') + ['user' => $node]);
    }
}
