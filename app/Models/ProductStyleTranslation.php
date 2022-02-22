<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the product_style_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class ProductStyleTranslation extends Model
{
 /**
 * The table associated with the model ProductStyleTranslation
 *
 * @var string
 */
    protected $table = 'product_style_translations';

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
    protected $fillable = ['style'];

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
    * Relationship with the App\Models\ProductStyle model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function productStyles()
    {
        return $this->belongsTo('App\Models\ProductStyle', 'product_styles_id', 'id');
    }

}
