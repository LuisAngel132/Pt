<?php
namespace App\Models;

use App\Traits\S3Trait;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the base_categories table
 *
 * automatically generated by ModelGenerator.php
 */
class BaseCategory extends Model {
	use S3Trait;
	/**
	 * The table associated with the model BaseCategory
	 *
	 * @var string
	 */
	protected $table = 'base_categories';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['image_url', 'is_active'];

	protected $appends = [
		'public_image_url',
	];
	public function getPublicImageUrlAttribute() {
		return $this->temporaryUrl($this->attributes['image_url']);
	}

	/**
	 * Relationship with the App\Models\BaseCategoryTranslation model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function baseCategoryTranslations() {
		return $this->hasMany('App\Models\BaseCategoryTranslation', 'base_categories_id', 'id');
	}

	/**
	 * Relationship with the App\Models\CategoriesDesign model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function categoriesDesigns() {
		return $this->hasMany('App\Models\CategoriesDesign', 'base_categories_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ModelsCategory model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function modelsCategories() {
		return $this->hasMany('App\Models\ModelsCategory', 'base_categories_id', 'id');
	}

}
