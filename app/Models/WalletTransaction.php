<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WalletTransaction
 * 
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property float $amount
 * @property string|null $reference
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class WalletTransaction extends Model
{
	protected $casts = [
		'user_id' => 'int',
		'amount' => 'float'
	];

	protected $guarded = [];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
