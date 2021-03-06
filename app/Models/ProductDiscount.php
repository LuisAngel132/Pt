<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the product_discounts table
 *
 * automatically generated by ModelGenerator.php
 */
class ProductDiscount extends Model
{
 /**
 * The table associated with the model ProductDiscount
 *
 * @var string
 */
    protected $table = 'product_discounts';

    public function getDates()
    {
        return ['start_date', 'end_date'];
    }

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['is_active', 'start_date', 'end_date'];

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

