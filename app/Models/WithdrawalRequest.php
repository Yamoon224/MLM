<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class WithdrawalRequest
 *
 * @property int         $id
 * @property int         $user_id
 * @property float       $amount
 * @property string      $method
 * @property string      $phone_number
 * @property string      $status   PENDING|APPROVED|REJECTED
 * @property string|null $admin_note
 * @property int|null    $processed_by
 * @property Carbon|null $processed_at
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 *
 * @property User $user
 */
class WithdrawalRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'user_id'      => 'int',
        'amount'       => 'float',
        'processed_by' => 'int',
        'processed_at' => 'datetime',
    ];

    // ──────────────────────────────────
    // Relations
    // ──────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ──────────────────────────────────
    // Scopes
    // ──────────────────────────────────

    public function scopePending(Builder $q): Builder
    {
        return $q->where('status', 'PENDING');
    }

    public function scopeApproved(Builder $q): Builder
    {
        return $q->where('status', 'APPROVED');
    }

    public function scopeRejected(Builder $q): Builder
    {
        return $q->where('status', 'REJECTED');
    }

    // ──────────────────────────────────
    // Helpers
    // ──────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'PENDING';
    }

    public function isApproved(): bool
    {
        return $this->status === 'APPROVED';
    }

    public function isRejected(): bool
    {
        return $this->status === 'REJECTED';
    }

    /** Couleur CSS Tailwind selon le statut */
    public function statusColor(): string
    {
        return match ($this->status) {
            'PENDING'  => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
            'APPROVED' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
            'REJECTED' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
            default    => 'bg-slate-100 text-slate-500',
        };
    }

    /** Label traduit du statut */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'PENDING'  => __('locale.withdrawal_pending'),
            'APPROVED' => __('locale.withdrawal_approved'),
            'REJECTED' => __('locale.withdrawal_rejected'),
            default    => $this->status,
        };
    }
}
