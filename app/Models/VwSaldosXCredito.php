<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VwSaldosXCredito
 * 
 * @property int $fechask
 * @property Carbon $fecha_cartera
 * @property int $id_credito
 * @property int $id_deudor
 * @property float $tasa_interes
 * @property string $nombre_deudor
 * @property string|null $grupo_economico
 * @property int $id_oficial
 * @property string $nom_oficial_part
 * @property string $nom_oficial_cred
 * @property int $id_estado_part
 * @property string|null $desc_estado_part
 * @property int $id_estado_op
 * @property string|null $descripcion_op
 * @property int $id_pais_destino
 * @property string|null $pais_destino
 * @property int $id_pais_origen
 * @property string|null $pais_origen
 * @property int $id_linea_negocio
 * @property string|null $des_linea_negocio
 * @property float $monto_credito
 * @property float $saldo_principal
 * @property float $saldo_interes
 * @property float $interes_diario
 * @property float $monto_part
 * @property float $tasa_interes_part
 * @property float $saldo_interes_part
 * @property float $interes_diario_part
 * @property Carbon $fecha_apertura
 * @property Carbon $fecha_vencimiento
 * @property Carbon $fecha_mov
 * @property string|null $periodicidad_interes_credito
 * @property string|null $analista
 * @property string|null $Industria
 * @property string|null $Industria_HLF
 * @property string|null $garantia
 * @property string|null $plazo
 * @property string|null $tipo_garantia
 * @property string|null $amortiza
 * @property string|null $relacionado
 * @property int|null $aprobado_hlf
 * @property int|null $aprobado_hco
 * @property int|null $id_cir
 * @property int|null $disponible_venta
 *
 * @package App\Models
 */
class VwSaldosXCredito extends Model
{
	protected $table = 'vw_saldos_x_creditos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechask' => 'int',
		'id_credito' => 'int',
		'id_deudor' => 'int',
		'tasa_interes' => 'float',
		'id_oficial' => 'int',
		'id_estado_part' => 'int',
		'id_estado_op' => 'int',
		'id_pais_destino' => 'int',
		'id_pais_origen' => 'int',
		'id_linea_negocio' => 'int',
		'monto_credito' => 'float',
		'saldo_principal' => 'float',
		'saldo_interes' => 'float',
		'interes_diario' => 'float',
		'monto_part' => 'float',
		'tasa_interes_part' => 'float',
		'saldo_interes_part' => 'float',
		'interes_diario_part' => 'float',
		'aprobado_hlf' => 'int',
		'aprobado_hco' => 'int',
		'id_cir' => 'int',
		'disponible_venta' => 'int'
	];

	protected $dates = [
		'fecha_cartera',
		'fecha_apertura',
		'fecha_vencimiento',
		'fecha_mov'
	];

	protected $fillable = [
		'fechask',
		'fecha_cartera',
		'id_credito',
		'id_deudor',
		'tasa_interes',
		'nombre_deudor',
		'grupo_economico',
		'id_oficial',
		'nom_oficial_part',
		'nom_oficial_cred',
		'id_estado_part',
		'desc_estado_part',
		'id_estado_op',
		'descripcion_op',
		'id_pais_destino',
		'pais_destino',
		'id_pais_origen',
		'pais_origen',
		'id_linea_negocio',
		'des_linea_negocio',
		'monto_credito',
		'saldo_principal',
		'saldo_interes',
		'interes_diario',
		'monto_part',
		'tasa_interes_part',
		'saldo_interes_part',
		'interes_diario_part',
		'fecha_apertura',
		'fecha_vencimiento',
		'fecha_mov',
		'periodicidad_interes_credito',
		'analista',
		'Industria',
		'Industria_HLF',
		'garantia',
		'plazo',
		'tipo_garantia',
		'amortiza',
		'relacionado',
		'aprobado_hlf',
		'aprobado_hco',
		'id_cir',
		'disponible_venta'
	];
}
