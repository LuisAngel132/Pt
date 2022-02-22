<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the discount_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class DiscountTranslation extends Model
{
 /**
 * The table associated with the model DiscountTranslation
 *
 * @var string
 */
    protected $table = 'discount_translations';

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
    protected $fillable = ['type', 'description'];

    /**
    * Relationship with the App\Models\DiscountType model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function discountTypes()
    {
        return $this->belongsTo('App\Models\DiscountType', 'discount_types_id', 'id');
    }

    /**
    * Relationship with the App\Models\Lang model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function langs()
    {
        return $this->belongsTo('App\Models\Lang', 'langs_id', 'id');
    }

}

