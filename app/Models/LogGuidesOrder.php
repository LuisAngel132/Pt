<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the log_guides_orders table
 *
 * automatically generated by ModelGenerator.php
 */
class LogGuidesOrder extends Model
{
 /**
 * The table associated with the model LogGuidesOrder
 *
 * @var string
 */
    protected $table = 'log_guides_orders';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [];

    /**
    * Relationship with the App\Models\LogGuide model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function logGuides()
    {
        return $this->belongsTo('App\Models\LogGuide', 'log_guides_id', 'id');
    }

    /**
    * Relationship with the App\Models\Order model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function orders()
    {
        return $this->belongsTo('App\Models\Order', 'orders_id', 'id');
    }

}

