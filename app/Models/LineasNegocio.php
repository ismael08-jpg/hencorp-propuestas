<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LineasNegocio
 * 
 * @property int $id_linea_negocio
 * @property string|null $des_linea_negocio
 *
 * @package App\Models
 */
class LineasNegocio extends Model
{
	protected $table = 'lineas_negocio';
	protected $primaryKey = 'id_linea_negocio';
	public $timestamps = false;

	protected $fillable = [
		'des_linea_negocio'
	];
}
