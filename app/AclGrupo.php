<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AclGrupo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'acl_grupos';
    
    protected $fillable = [ 'id', 'nombre', 'descripcion', 'url', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
