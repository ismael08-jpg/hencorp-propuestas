<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VwSaldosXParticipacion
 * 
 * @property int $fechask
 * @property int $id_credito
 * @property int $id_participante
 * @property string $nom_participante
 * @property int $id_deudor
 * @property string $nombre_deudor
 * @property string|null $grupo_economico
 * @property int $id_oficial
 * @property string $nom_oficial_part
 * @property int $id_estado_part
 * @property string|null $desc_estado_part
 * @property int $id_estado_op
 * @property string|null $descripcion_op
 * @property int $id_pais_destino
 * @property string|null $pais_destino
 * @property int $id_pais_riesgo
 * @property string|null $pais_riesgo
 * @property int $id_empresa
 * @property string $nom_empresa
 * @property float $saldo
 * @property float $tasa_interes
 * @property float $saldo_interes
 * @property float $interes_diario
 * @property float|null $tasa_credito
 * @property float|null $saldo_credito
 * @property float|null $part_tot_credito
 * @property string|null $ref_credito
 * @property Carbon $fecha_apertura
 * @property Carbon $fecha_vencimiento
 * @property string|null $alias_participacion
 * @property string|null $alias_credito
 * @property string|null $rm_credito
 * @property string $nom_oficial_credito
 * @property int|null $id_cir
 *
 * @package App\Models
 */
class VwSaldosXParticipacion extends Model
{
	protected $table = 'vw_saldos_x_participacion';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fechask' => 'int',
		'id_credito' => 'int',
		'id_participante' => 'int',
		'id_deudor' => 'int',
		'id_oficial' => 'int',
		'id_estado_part' => 'int',
		'id_estado_op' => 'int',
		'id_pais_destino' => 'int',
		'id_pais_riesgo' => 'int',
		'id_empresa' => 'int',
		'saldo' => 'float',
		'tasa_interes' => 'float',
		'saldo_interes' => 'float',
		'interes_diario' => 'float',
		'tasa_credito' => 'float',
		'saldo_credito' => 'float',
		'part_tot_credito' => 'float',
		'id_cir' => 'int'
	];

	protected $dates = [
		'fecha_apertura',
		'fecha_vencimiento'
	];

	protected $fillable = [
		'fechask',
		'id_credito',
		'id_participante',
		'nom_participante',
		'id_deudor',
		'nombre_deudor',
		'grupo_economico',
		'id_oficial',
		'nom_oficial_part',
		'id_estado_part',
		'desc_estado_part',
		'id_estado_op',
		'descripcion_op',
		'id_pais_destino',
		'pais_destino',
		'id_pais_riesgo',
		'pais_riesgo',
		'id_empresa',
		'nom_empresa',
		'saldo',
		'tasa_interes',
		'saldo_interes',
		'interes_diario',
		'tasa_credito',
		'saldo_credito',
		'part_tot_credito',
		'ref_credito',
		'fecha_apertura',
		'fecha_vencimiento',
		'alias_participacion',
		'alias_credito',
		'rm_credito',
		'nom_oficial_credito',
		'id_cir'
	];
}
