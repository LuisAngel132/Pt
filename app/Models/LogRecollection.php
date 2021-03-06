<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the log_recollections table
 *
 * automatically generated by ModelGenerator.php
 */
class LogRecollection extends Model
{
 /**
 * The table associated with the model LogRecollection
 *
 * @var string
 */
    protected $table = 'log_recollections';

    public function getDates()
    {
        return ['pickup_date', 'pickup_ready_time', 'pickup_close_time'];
    }

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['pickup_confirmation_number', 'pickup_date', 'pickup_ready_time', 'pickup_close_time'];

    /**
    * Relationship with the App\Models\User model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    /**
    * Relationship with the App\Models\LogRecollectionsOrder model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function logRecollectionsOrders()
    {
        return $this->hasMany('App\Models\LogRecollectionsOrder', 'log_recollections_id', 'id');
    }

}

