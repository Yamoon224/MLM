<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{
    /**
     * Routes exemptées de la vérification (en plus de logout).
     */
    private const EXEMPT_ROUTES = [
        'account.renewal.show',
        'account.renewal.store',
        'logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($request->routeIs(...self::EXEMPT_ROUTES)) {
                return $next($request);
            }

            // Désactiver si expiré (au cas où la commande n'aurait pas encore tourné)
            if ($user->isExpired() && $user->is_active) {
                $user->update(['is_active' => false]);
            }

            if (!$user->is_active) {
                return redirect()->route('account.renewal.show');
            }
        }

        return $next($request);
    }
}
