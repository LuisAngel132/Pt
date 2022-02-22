<?php
namespace App\Models;

use App\Traits\S3Trait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use S3Trait;
    use Notifiable;
    /**
     * The table associated with the model User
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'is_active', 'image_url', 'people_id'];

    /**
     * Relationship with the App\Models\Person model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function people()
    {
        return $this->belongsTo('App\Models\Person', 'people_id', 'id');
    }

    /**
     * Relationship with the App\Models\Customer model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function customers()
    {
        return $this->hasMany('App\Models\Customer', 'users_id', 'id');
    }

    /**
     * Relationship with the App\Models\RoleUser model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function roleUsers()
    {
        return $this->hasMany('App\Models\RoleUser', 'users_id', 'id');
    }

    /**
     * Relationship with the App\Models\Staff model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function staffs()
    {
        return $this->hasMany('App\Models\Staff', 'users_id', 'id');
    }

    /**
     * Relationship with the App\Models\SuppliersUser model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function suppliersUsers()
    {
        return $this->hasMany('App\Models\SuppliersUser', 'users_id', 'id');
    }

    /**
     * Relationship with the App\Models\UserServiceProvider model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function userServiceProviders()
    {
        return $this->hasMany('App\Models\UserServiceProvider', 'users_id', 'id');
    }

    /**
     * Relationship with the App\Models\UsersRefund model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function usersRefunds()
    {
        return $this->hasMany('App\Models\UsersRefund', 'users_id', 'id');
    }

    /**
     * Relationship with the App\Models\Role model.
     *
     * @return    Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_users', 'users_id', 'roles_id');
    }
}
