<?php

if (! function_exists('xaf')) {
    /**
     * Formate un montant en XAF (Franc CFA).
     * Exemple : xaf(10000) → "10 000 FCFA"
     */
    function xaf(float|int|null $amount, bool $withSymbol = true): string
    {
        $formatted = number_format((float) ($amount ?? 0), 0, ',', ' ');
        return $withSymbol ? $formatted . ' FCFA' : $formatted;
    }
}
