<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the movement_outlets table
 *
 * automatically generated by ModelGenerator.php
 */
class MovementOutlet extends Model
{
 /**
 * The table associated with the model MovementOutlet
 *
 * @var string
 */
    protected $table = 'movement_outlets';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [];

    /**
    * Relationship with the App\Models\Movement model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function movements()
    {
        return $this->belongsTo('App\Models\Movement', 'movements_id', 'id');
    }

    /**
    * Relationship with the App\Models\Outlet model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function outlets()
    {
        return $this->belongsTo('App\Models\Outlet', 'outlets_id', 'id');
    }

}
