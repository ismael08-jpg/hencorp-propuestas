<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'usuario',
        'tipo_usuario',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tipos_usuario()
	{
		return $this->belongsTo(TiposUsuario::class, 'tipo_usuario');
	}
    
    public function autorizarRol($roles){
        abort_unless($this->tieneAlgunRol($roles), 401);
        return true;
    }
    
    public function autorizarAccion($roles){
        if($this->tieneAlgunRol($roles)){
            return true;
        }
        return false;
    }

    public function tieneAlgunRol($roles){
        if(is_array($roles)){
            foreach($roles as $rol){
                if($this->tieneRol($rol)){
                    return true;
                }
            }
        }else{
            if($this->tieneRol($roles)){
                return true;
            }
        }
        return false;
    }

    public function tieneRol($rol){
        if($this->tipos_usuario()->where('id_tipo_usuario', $rol)->first()){
            return true;
        }
        return false;
    }

}
