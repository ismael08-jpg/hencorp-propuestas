<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CotCreditosDet
 * 
 * @property int $id_cotizacion
 * @property int $id_credito
 * @property string $nombre_deudor
 * @property string|null $grupo_economico
 * @property float|null $monto_cot
 * @property float|null $tasa_cot
 * @property float|null $rendimiento
 * @property string|null $fecha_cot
 * @property int|null $dias_inventario
 * @property string|null $comentarios
 * @property string|null $pais
 * @property string|null $industria
 * 
 * @property CotCreditosEnc $cot_creditos_enc
 *
 * @package App\Models
 */
class CotCreditosDet extends Model
{
	protected $table = 'cot_creditos_det';
	protected $primaryKey = 'id_cotizacion';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_cotizacion' => 'int',
		'id_credito' => 'int',
		'monto_cot' => 'float',
		'tasa_cot' => 'float',
		'rendimiento' => 'float',
		'dias_inventario' => 'int'
	];

	protected $fillable = [
		'id_cotizacion',
		'id_credito',
		'nombre_deudor',
		'grupo_economico',
		'monto_cot',
		'tasa_cot',
		'rendimiento',
		'fecha_cot',
		'dias_inventario',
		'comentarios',
		'pais',
		'industria'
	];

	public function cot_creditos_enc()
	{
		return $this->belongsTo(CotCreditosEnc::class, 'id_credito');
	}
}
