<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the people table
 *
 * automatically generated by ModelGenerator.php
 */
class Person extends Model
{
 /**
 * The table associated with the model Person
 *
 * @var string
 */
    protected $table = 'people';

 /**
 * Indicates if the model should be timestamped.
 *
 * @var bool
 */
    public $timestamps = false;

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['full_name', 'name', 'last_name', 'gender'];

    /**
    * Relationship with the App\Models\Sponsor model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function sponsors()
    {
        return $this->hasMany('App\Models\Sponsor', 'people_id', 'id');
    }

    /**
    * Relationship with the App\Models\User model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function users()
    {
        return $this->hasMany('App\Models\User', 'people_id', 'id');
    }

}

