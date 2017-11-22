<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'acl_users';
    protected $fillable = [ 'name', 'email', 'password', ];
    protected $hidden = [ 'password', 'remember_token', ];

    public static function validar_agregar($merge=[]) 
    {
        return array_merge(
        [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ], 
        $merge);
    }

    public function ultimo_login()
    {
        return $this->hasOne('App\AclLogin')->where('login_tipo_id', 1)->latest();
    }

    public function acl_grupos()
    {
        return $this->belongsToMany('App\AclGrupo', 'acl_grupos_usuarios', 'user_id', 'grupo_id')->withTimestamps();
    }
}
