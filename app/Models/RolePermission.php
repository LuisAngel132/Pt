<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the role_permissions table
 *
 * automatically generated by ModelGenerator.php
 */
class RolePermission extends Model
{
 /**
 * The table associated with the model RolePermission
 *
 * @var string
 */
    protected $table = 'role_permissions';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [];

    /**
    * Relationship with the App\Models\Permission model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function permissions()
    {
        return $this->belongsTo('App\Models\Permission', 'permissions_id', 'id');
    }

    /**
    * Relationship with the App\Models\Role model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function roles()
    {
        return $this->belongsTo('App\Models\Role', 'roles_id', 'id');
    }

}

