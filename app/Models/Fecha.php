<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fecha
 * 
 * @property int|null $CODIGO
 * @property Carbon|null $FECHA
 * @property int|null $FECHASK
 * @property string|null $TABLA
 * @property string|null $DESCRIPCION
 * @property Carbon|null $FECHA_GRA
 * @property Carbon|null $FECHA_MOD
 *
 * @package App\Models
 */
class Fecha extends Model
{
	protected $table = 'fechas';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'CODIGO' => 'int',
		'FECHASK' => 'int'
	];

	protected $dates = [
		'FECHA',
		'FECHA_GRA',
		'FECHA_MOD'
	];

	protected $fillable = [
		'CODIGO',
		'FECHA',
		'FECHASK',
		'TABLA',
		'DESCRIPCION',
		'FECHA_GRA',
		'FECHA_MOD'
	];
}
