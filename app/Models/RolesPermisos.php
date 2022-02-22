<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesPermisos extends Model
{
    	protected $table = 'roles_has_permissions';
	public $timestamps = true;
	protected $fillable = [
		'roles_id',
	 	'permissions_id'
	];
	public function permisos()
    	{
		return $this->belongsTo('App\Permiso', 'permissions_id' );
    	}
}
