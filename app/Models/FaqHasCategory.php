<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the faq_has_categories table
 *
 * automatically generated by ModelGenerator.php
 */
class FaqHasCategory extends Model
{
 /**
 * The table associated with the model FaqHasCategory
 *
 * @var string
 */
    protected $table = 'faq_has_categories';

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['is_active'];

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
    * Relationship with the App\Models\Faq model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function faqs()
    {
        return $this->belongsTo('App\Models\Faq', 'faqs_id', 'id');
    }

}
