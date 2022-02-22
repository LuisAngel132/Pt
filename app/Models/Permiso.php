<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permissions';
	public $timestamps = false;
	protected $fillable = [
		'name',
	 	'display_name',
	 	'description',
	 	'is_active'
	];

	public function hasRoles()
	{
		return $this->hasMany('App\RolesPermisos', 'permissions_id');
	}
}
