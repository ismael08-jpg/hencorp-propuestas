<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Deudore
 * 
 * @property int $id_deudor
 * @property string $nombre_deudor
 * @property float|null $credito_aprobado
 * @property string|null $grupo_economico
 * @property Carbon|null $fecha_gra
 * @property Carbon|null $fecha_mod
 * @property string|null $industria
 * @property string|null $relacionado
 * @property string|null $industria_hlf
 * @property bool|null $aprobado_hco
 * @property bool|null $aprobado_hlf
 *
 * @package App\Models
 */
class Deudore extends Model
{
	protected $table = 'deudores';
	protected $primaryKey = 'id_deudor';
	public $timestamps = false;

	protected $casts = [
		'credito_aprobado' => 'float',
		'aprobado_hco' => 'bool',
		'aprobado_hlf' => 'bool'
	];

	protected $dates = [
		'fecha_gra',
		'fecha_mod'
	];

	protected $fillable = [
		'nombre_deudor',
		'credito_aprobado',
		'grupo_economico',
		'fecha_gra',
		'fecha_mod',
		'industria',
		'relacionado',
		'industria_hlf',
		'aprobado_hco',
		'aprobado_hlf'
	];
}
