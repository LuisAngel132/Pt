<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the order_status_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class OrderStatusTranslation extends Model
{
 /**
 * The table associated with the model OrderStatusTranslation
 *
 * @var string
 */
    protected $table = 'order_status_translations';

    public $primaryKey = '';

 /**
 * Indicates if the model should be timestamped.
 *
 * @var bool
 */
    public $timestamps = false;

    public $incrementing = false;

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['status', 'description'];

    /**
    * Relationship with the App\Models\Lang model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function langs()
    {
        return $this->belongsTo('App\Models\Lang', 'langs_id', 'id');
    }

    /**
    * Relationship with the App\Models\OrderStatus model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function orderStatus()
    {
        return $this->belongsTo('App\Models\OrderStatus', 'order_status_id', 'id');
    }

}

