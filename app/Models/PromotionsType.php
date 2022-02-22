<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the promotions_types table
 *
 * automatically generated by ModelGenerator.php
 */
class PromotionsType extends Model
{
 /**
 * The table associated with the model PromotionsType
 *
 * @var string
 */
    protected $table = 'promotions_types';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [];

    /**
    * Relationship with the App\Models\CodesPromotionsType model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function codesPromotionsTypes()
    {
        return $this->hasMany('App\Models\CodesPromotionsType', 'promotions_types_id', 'id');
    }

    /**
    * Relationship with the App\Models\PromotionsTypesTranslation model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function promotionsTypesTranslations()
    {
        return $this->hasMany('App\Models\PromotionsTypesTranslation', 'promotions_types_id', 'id');
    }

}
