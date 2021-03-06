<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the payment_method_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class PaymentMethodTranslation extends Model
{
 /**
 * The table associated with the model PaymentMethodTranslation
 *
 * @var string
 */
    protected $table = 'payment_method_translations';

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
    protected $fillable = ['method'];

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
    * Relationship with the App\Models\PaymentMethod model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function paymentMethods()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_methods_id', 'id');
    }

}

