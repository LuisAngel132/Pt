<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the faq_category_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class FaqCategoryTranslation extends Model
{
 /**
 * The table associated with the model FaqCategoryTranslation
 *
 * @var string
 */
    protected $table = 'faq_category_translations';

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
    protected $fillable = ['category'];

    /**
    * Relationship with the App\Models\FaqCategory model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function faqCategories()
    {
        return $this->belongsTo('App\Models\FaqCategory', 'faq_categories_id', 'id');
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

