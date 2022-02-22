<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the orders_coupons table
 *
 * automatically generated by ModelGenerator.php
 */
class OrdersCoupon extends Model
{
 /**
 * The table associated with the model OrdersCoupon
 *
 * @var string
 */
    protected $table = 'orders_coupons';

    public $primaryKey = 'int';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [];

    /**
    * Relationship with the App\Models\Customer model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function customers()
    {
        return $this->belongsTo('App\Models\Customer', 'customers_id', 'id');
    }

    /**
    * Relationship with the App\Models\Code model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function codes()
    {
        return $this->belongsTo('App\Models\Code', 'codes_id', 'id');
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

