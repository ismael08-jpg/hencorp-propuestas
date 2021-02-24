<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SaldosXCredito
 * 
 * @property int|null $dias_mora
 * @property int $fechask
 * @property int $id_credito
 * @property int $id_deudor
 * @property int $id_oficial
 * @property int $id_estado_part
 * @property int $id_estado_op
 * @property int $id_pais_origen
 * @property int $id_pais_destino
 * @property int $id_linea_negocio
 * @property int $id_periodo_interes
 * @property float $monto_credito
 * @property float $saldo_principal
 * @property float $tasa_interes
 * @property float $saldo_interes
 * @property float $interes_diario
 * @property float $monto_part
 * @property float $tasa_interes_part
 * @property float $saldo_interes_part
 * @property float $interes_diario_part
 * @property string $ban_mora
 * @property Carbon $fecha_apertura
 * @property Carbon $fecha_vencimiento
 * @property Carbon $fecha_mov
 * @property Carbon|null $fecha_gra
 * @property string|null $fecha_mod
 * @property Carbon $fecha_cartera
 * @property string|null $periodicidad_interes_credito
 * @property string|null $analista
 * @property string|null $garantia
 * @property string|null $plazo
 * @property string|null $tipo_garantia
 * @property string|null $asignacion_pago
 * @property string|null $amortiza
 * @property int|null $id_cir
 *
 * @package App\Models
 */
class SaldosXCredito extends Model
{
	protected $table = 'saldos_x_creditos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'dias_mora' => 'int',
		'fechask' => 'int',
		'id_credito' => 'int',
		'id_deudor' => 'int',
		'id_oficial' => 'int',
		'id_estado_part' => 'int',
		'id_estado_op' => 'int',
		'id_pais_origen' => 'int',
		'id_pais_destino' => 'int',
		'id_linea_negocio' => 'int',
		'id_periodo_interes' => 'int',
		'monto_credito' => 'float',
		'saldo_principal' => 'float',
		'tasa_interes' => 'float',
		'saldo_interes' => 'float',
		'interes_diario' => 'float',
		'monto_part' => 'float',
		'tasa_interes_part' => 'float',
		'saldo_interes_part' => 'float',
		'interes_diario_part' => 'float',
		'id_cir' => 'int'
	];

	protected $dates = [
		'fecha_apertura',
		'fecha_vencimiento',
		'fecha_mov',
		'fecha_gra',
		'fecha_cartera'
	];

	protected $fillable = [
		'dias_mora',
		'id_deudor',
		'id_oficial',
		'id_estado_part',
		'id_estado_op',
		'id_pais_origen',
		'id_pais_destino',
		'id_linea_negocio',
		'id_periodo_interes',
		'monto_credito',
		'saldo_principal',
		'tasa_interes',
		'saldo_interes',
		'interes_diario',
		'monto_part',
		'tasa_interes_part',
		'saldo_interes_part',
		'interes_diario_part',
		'ban_mora',
		'fecha_apertura',
		'fecha_vencimiento',
		'fecha_mov',
		'fecha_gra',
		'fecha_mod',
		'fecha_cartera',
		'periodicidad_interes_credito',
		'analista',
		'garantia',
		'plazo',
		'tipo_garantia',
		'asignacion_pago',
		'amortiza',
		'id_cir'
	];
}
