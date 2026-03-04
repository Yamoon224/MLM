<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MatrixClosure
 * 
 * @property int $ancestor_id
 * @property int $descendant_id
 * @property int $depth
 *
 * @package App\Models
 */
class MatrixClosure extends Model
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ancestor_id' => 'int',
		'descendant_id' => 'int',
		'depth' => 'int'
	];

	protected $guarded = [];
}
