<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'role_users';
	public $timestamps = true;
	protected $fillable = [
		'roles_id',
	 	'users_id'
	];
	public function rolUser()
	{
		return $this->belongsTo('App\Models\User', 'users_id' );
	}
	public function userRol()
	{
		return $this->belongsTo('App\Models\Rol', 'roles_id' );
	}
}
