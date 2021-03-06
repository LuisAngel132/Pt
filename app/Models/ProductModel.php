<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the product_models table
 *
 * automatically generated by ModelGenerator.php
 */
class ProductModel extends Model
{
 /**
 * The table associated with the model ProductModel
 *
 * @var string
 */
    protected $table = 'product_models';

    public $incrementing = false;

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [];

    /**
    * Relationship with the App\Models\Model model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function models()
    {
        return $this->belongsTo('App\Models\Model', 'models_id', 'id');
    }

    /**
    * Relationship with the App\Models\Product model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function products()
    {
        return $this->belongsTo('App\Models\Product', 'products_id', 'id');
    }

}

