<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Participante
 * 
 * @property int $id_participante
 * @property string $nom_participante
 * @property Carbon|null $fecha_gra
 * @property Carbon|null $fecha_mod
 * @property string|null $tipo_participante
 *
 * @package App\Models
 */
class Participante extends Model
{
	protected $table = 'participante';
	protected $primaryKey = 'id_participante';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_participante' => 'int'
	];

	protected $dates = [
		'fecha_gra',
		'fecha_mod'
	];

	protected $fillable = [
		'nom_participante',
		'fecha_gra',
		'fecha_mod',
		'tipo_participante'
	];
}
