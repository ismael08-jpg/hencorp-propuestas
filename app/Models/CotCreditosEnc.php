<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CotCreditosEnc
 * 
 * @property int $id_cotizacion
 * @property float|null $monto_cot
 * @property float|null $tasa_ponderada
 * @property float|null $dias_ponderados
 * @property string|null $estado_cot
 * @property int|null $usuario_cot
 * @property string $nombre_deudor
 * @property Carbon|null $fecha_cot
 * 
 * @property Collection|CotCreditosDet[] $cot_creditos_dets
 *
 * @package App\Models
 */
class CotCreditosEnc extends Model
{
	protected $table = 'cot_creditos_enc';
	protected $primaryKey = 'id_cotizacion';
	public $timestamps = false;

	protected $casts = [
		'monto_cot' => 'float',
		'tasa_ponderada' => 'float',
		'dias_ponderados' => 'float',
		'usuario_cot' => 'int'
	];

	protected $dates = [
		'fecha_cot'
	];

	protected $fillable = [
		'monto_cot',
		'tasa_ponderada',
		'dias_ponderados',
		'estado_cot',
		'usuario_cot',
		'nombre_deudor',
		'fecha_cot'
	];

	public function cot_creditos_dets()
	{
		return $this->hasMany(CotCreditosDet::class, 'id_credito');
	}
}
