<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStyleType extends Model
{
 /**
 * The table associated with the model ProductStyle
 *
 * @var string
 */
    protected $table = 'product_styles_type';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['name','is_active'];

    /**
    * Relationship with the App\Models\ProductStyleTranslation model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function productStyleType()
    {
        return $this->hasMany('App\Models\ProductStyleTranslation', 'product_styles_type_id', 'id');
    }

    /**
    * Relationship with the App\Models\Product model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
   

}