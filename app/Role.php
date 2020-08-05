<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";        
    protected $primaryKey = "id";

    CONST ROLE_WARGA = '1';
    CONST ROLE_BILLING = '2';
    CONST ROLE_ADMIN = '3';

    protected $fillable = [
        'id',         
        'role',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->hasMany('App\User', 'role_id', 'id');
    }

    public static function generate($role_id)
    {
        return Role::where('id', $role_id)->first();
    }

}
