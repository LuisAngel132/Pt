<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
	protected $table = 'roles';
	public $timestamps = false;
	protected $fillable = [
		'name',
	 	'display_name',
	 	'description'
	];
	public function permisosasignados(){
         return $this->hasMany('App\RolesPermisos', 'roles_id', 'id');
    }
    public function rolesusuarios(){
         return $this->hasMany('App\UserRoles', 'roles_id', 'id');
    }
    
}
