<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the sizes_guides table
 *
 * automatically generated by ModelGenerator.php
 */
class SizesGuide extends Model
{
 /**
 * The table associated with the model SizesGuide
 *
 * @var string
 */
    protected $table = 'sizes_guides';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['guide_image'];

    /**
    * Relationship with the App\Models\ProductGenre model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function productGenres()
    {
        return $this->belongsTo('App\Models\ProductGenre', 'product_genres_id', 'id');
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

    /**
    * Relationship with the App\Models\ProductType model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function productTypes()
    {
        return $this->belongsTo('App\Models\ProductType', 'product_types_id', 'id');
    }

    /**
    * Relationship with the App\Models\Size model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function sizes()
    {
        return $this->belongsTo('App\Models\Size', 'sizes_id', 'id');
    }

    /**
    * Relationship with the App\Models\SizesGuidesTranslation model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function sizesGuidesTranslations()
    {
        return $this->hasMany('App\Models\SizesGuidesTranslation', 'sizes_guides_id', 'id');
    }

}

