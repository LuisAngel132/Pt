<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the customer_payments table
 *
 * automatically generated by ModelGenerator.php
 */
class CustomerPayment extends Model
{
 /**
 * The table associated with the model CustomerPayment
 *
 * @var string
 */
    protected $table = 'customer_payments';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['details', 'is_default', 'is_active'];

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
    * Relationship with the App\Models\PaymentMethod model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function paymentMethods()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_methods_id', 'id');
    }

    /**
    * Relationship with the App\Models\OrderPayment model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function orderPayments()
    {
        return $this->hasMany('App\Models\OrderPayment', 'customer_payments_id', 'id');
    }

    /**
    * Relationship with the App\Models\PaymentCard model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function paymentCards()
    {
        return $this->hasMany('App\Models\PaymentCard', 'customer_payments_id', 'id');
    }

}

