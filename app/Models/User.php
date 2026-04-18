<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
		'sponsor_id' => 'int',
		'matrix_parent_id' => 'int',
		'matrix_level' => 'int',
		'is_active' => 'bool',
		'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'matrix_children_count' => 'int',
        'expires_at' => 'datetime',
	];

    public function sponsor()
	{
		return $this->belongsTo(User::class, 'sponsor_id');
	}

	public function sponsored()
	{
		return $this->hasMany(User::class, 'sponsor_id');
	}

    public function matrix_parent()
	{
		return $this->belongsTo(User::class, 'matrix_parent_id');
	}

	public function matrix_children()
	{
		return $this->hasMany(User::class, 'matrix_parent_id');
	}

	public function wallet_transactions()
	{
		return $this->hasMany(WalletTransaction::class);
	}

    public function bonus($type = 'REFERRAL_BONUS') 
    {
        return $this->wallet_transactions()->where(compact('type'))->sum('amount');
    }

	public function wallet()
	{
		return $this->hasOne(Wallet::class);
	}

    public function withdrawalRequests()
    {
        return $this->hasMany(\App\Models\WithdrawalRequest::class);
    }

    public function pendingWithdrawal()
    {
        return $this->withdrawalRequests()->where('status', 'PENDING')->first();
    }

	// Relation closure table pour descendants
    public function descendants()
    {
        return $this->belongsToMany(
            User::class,
            'matrix_closure',
            'ancestor_id',
            'descendant_id'
        )->withPivot('depth');
    }

    // Relation closure table pour ancestors
    public function ancestors()
    {
        return $this->belongsToMany(
            User::class,
            'matrix_closure',
            'descendant_id',
            'ancestor_id'
        )->withPivot('depth');
    }

    public function childrenAtLevel(int $level)
    {
        return $this->descendants()->where('pivot_depth', $level);
    }

    public function accountRenewals()
    {
        return $this->hasMany(AccountRenewal::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function scopeExpired($query)
    {
        return $query->where('is_active', true)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now());
    }
}
