<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the models table
 *
 * automatically generated by ModelGenerator.php
 */
class Modelo extends Model
{
 /**
 * The table associated with the model Model
 *
 * @var string
 */
    protected $table = 'models';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['model', 'url', 'is_active','image_url', 'model_ios', 'model_android'];

    /**
    * Relationship with the App\Models\ModelsCategory model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function modelsCategories()
    {
        return $this->hasMany('App\Models\ModelsCategory', 'models_id', 'id');
    }

    /**
    * Relationship with the App\Models\ProductModel model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function productModels()
    {
        return $this->hasMany('App\Models\ProductModel', 'models_id', 'id');
    }

}

