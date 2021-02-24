<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CotCredito
 * 
 * @property int $id_cotizacion
 * @property int $id_credito
 * @property string $nombre_deudor
 * @property string|null $grupo_economico
 * @property string $nombre_cotizacion
 * @property float|null $monto_cot
 * @property float|null $tasa_cot
 * @property string $estado_cot
 * @property string|null $usuario_cot
 * @property string|null $fecha_cot
 * @property string|null $comentarios
 *
 * @package App\Models
 */
class CotCredito extends Model
{
	protected $table = 'cot_creditos';
	public $timestamps = false;

	protected $casts = [
		'id_credito' => 'int',
		'monto_cot' => 'float',
		'tasa_cot' => 'float'
	];

	protected $fillable = [
		'nombre_deudor',
		'grupo_economico',
		'nombre_cotizacion',
		'monto_cot',
		'tasa_cot',
		'estado_cot',
		'usuario_cot',
		'fecha_cot',
		'comentarios'
	];
}
