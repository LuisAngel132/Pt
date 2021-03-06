<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the refunds table
 *
 * automatically generated by ModelGenerator.php
 */
class Refund extends Model
{
 /**
 * The table associated with the model Refund
 *
 * @var string
 */
    protected $table = 'refunds';

    public function getDates()
    {
        return ['arrived_at'];
    }

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['image', 'description', 'is_attended', 'arrived_at', 'is_complete'];

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
    * Relationship with the App\Models\OrderProduct model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function orderProducts()
    {
        return $this->belongsTo('App\Models\OrderProduct', 'order_products_id', 'id');
    }

    /**
    * Relationship with the App\Models\UsersRefund model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function usersRefunds()
    {
        return $this->hasMany('App\Models\UsersRefund', 'refunds_id', 'id');
    }

}

