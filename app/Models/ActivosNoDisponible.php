<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivosNoDisponible
 * 
 * @property string $deudor
 * @property int $disponible
 *
 * @package App\Models
 */
class ActivosNoDisponible extends Model
{
	protected $table = 'activos_no_disponibles';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'disponible' => 'int'
	];

	protected $fillable = [
		'deudor',
		'disponible'
	];
}
