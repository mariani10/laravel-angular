<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AclLogin extends Model
{
    protected $table = 'acl_logins';

    protected $fillable = [ 'id', 'login_tipo_id', 'user_id', 'user_ip', 'user_agent', 'user_origen', 'created_at', 'updated_at', ];
}
