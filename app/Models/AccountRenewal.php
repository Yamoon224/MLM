<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property int    $user_id
 * @property float  $amount
 * @property string $payment_reference
 * @property string $status  pending|confirmed|rejected
 * @property Carbon|null $confirmed_at
 * @property Carbon|null $expires_at
 */
class AccountRenewal extends Model
{
    protected $casts = [
        'user_id'      => 'int',
        'amount'       => 'float',
        'confirmed_at' => 'datetime',
        'expires_at'   => 'datetime',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }
}
