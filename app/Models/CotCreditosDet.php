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
 * @property string|null $fecha_cot
 * @property string|null $comentarios
 * 
 * @property CotCreditosEnc $cot_creditos_enc
 *
 * @package App\Models
 */
class CotCreditosDet extends Model
{
	protected $table = 'cot_creditos_det';
	protected $primaryKey = 'id_cotizacion';
	public $timestamps = false;

	protected $casts = [
		'id_credito' => 'int',
		'monto_cot' => 'float',
		'tasa_cot' => 'float'
	];

	protected $fillable = [
		'id_credito',
		'nombre_deudor',
		'grupo_economico',
		'monto_cot',
		'tasa_cot',
		'fecha_cot',
		'comentarios'
	];

	public function cot_creditos_enc()
	{
		return $this->belongsTo(CotCreditosEnc::class, 'id_credito');
	}
}
