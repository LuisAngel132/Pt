<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the shipping_eta_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class ShippingEtaTranslation extends Model
{
 /**
 * The table associated with the model ShippingEtaTranslation
 *
 * @var string
 */
    protected $table = 'shipping_eta_translations';

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
    protected $fillable = ['eta'];

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
    * Relationship with the App\Models\ShippingEtum model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function shippingEta()
    {
        return $this->belongsTo('App\Models\ShippingEtum', 'shipping_eta_id', 'id');
    }

}

