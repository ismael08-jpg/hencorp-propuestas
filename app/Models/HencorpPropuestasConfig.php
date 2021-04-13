<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HencorpPropuestasConfig
 * 
 * @property int $id_config
 * @property float|null $rendimiento_hbc
 *
 * @package App\Models
 */
class HencorpPropuestasConfig extends Model
{
	protected $table = 'hencorp_propuestas_config';
	protected $primaryKey = 'id_config';
	public $timestamps = false;

	protected $casts = [
		'rendimiento_hbc' => 'float'
	];

	protected $fillable = [
		'rendimiento_hbc'
	];
}
