<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CotCatalogoCredito
 * 
 * @property Carbon $fecha_cartera
 * @property int $id_credito
 * @property string $nombre_deudor
 * @property string|null $grupo_economico
 * @property int|null $cant_participaciones
 * @property float $saldo_principal
 * @property float|null $porc_saldo_principal
 * @property float|null $NLP
 * @property float|null $costo_ponderado
 * @property Carbon $fecha_apertura
 * @property Carbon $fecha_vencimiento
 * @property int|null $dias_inventario
 * @property int|null $dias_al_vencimiento
 * @property string|null $des_linea_negocio
 * @property string $ESTADO
 *
 * @package App\Models
 */
class CotCatalogoCredito extends Model
{
	protected $table = 'cot_catalogo_creditos';
	protected $primaryKey = 'id_credito';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_credito' => 'int',
		'cant_participaciones' => 'int',
		'saldo_principal' => 'float',
		'porc_saldo_principal' => 'float',
		'NLP' => 'float',
		'costo_ponderado' => 'float',
		'dias_inventario' => 'int',
		'dias_al_vencimiento' => 'int'
	];

	protected $dates = [
		'fecha_cartera',
		'fecha_apertura',
		'fecha_vencimiento'
	];

	protected $fillable = [
		'fecha_cartera',
		'nombre_deudor',
		'grupo_economico',
		'cant_participaciones',
		'saldo_principal',
		'porc_saldo_principal',
		'NLP',
		'costo_ponderado',
		'fecha_apertura',
		'fecha_vencimiento',
		'dias_inventario',
		'dias_al_vencimiento',
		'des_linea_negocio',
		'ESTADO'
	];
}
