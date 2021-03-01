<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposUsuario
 * 
 * @property int $id_tipo_usuario
 * @property string $nombre
 * 
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class TiposUsuario extends Model
{
	protected $table = 'tipos_usuarios';
	protected $primaryKey = 'id_tipo_usuario';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function usuarios()
	{
		return $this->hasMany(User::class, 'tipo_usuario');
	}
}
