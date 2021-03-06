<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the products table
 *
 * automatically generated by ModelGenerator.php
 */
class Product extends Model {
	/**
	 * The table associated with the model Product
	 *
	 * @var string
	 */
	protected $table = 'products';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['sku', 'rating', 'is_active'];

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = [
		'average_rating',
	];

	public function getAverageRatingAttribute() {
		return (int) $this->customerRatings()->get()->avg('rating') ?? 0;
	}

	/**
	 * Relationship with the App\Models\ProductGenre model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function productGenres() {
		return $this->belongsTo('App\Models\ProductGenre', 'product_genres_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ProductStyle model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function productStyles() {
		return $this->belongsTo('App\Models\ProductStyle', 'product_styles_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ProductType model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function productTypes() {
		return $this->belongsTo('App\Models\ProductType', 'product_types_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Cart model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function carts() {
		return $this->hasMany('App\Models\Cart', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\CustomerDesign model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function customerDesigns() {
		return $this->hasMany('App\Models\CustomerDesign', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\CustomerLike model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function customerLikes() {
		return $this->hasMany('App\Models\CustomerLike', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\CustomerRating model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function customerRatings() {
		return $this->hasMany('App\Models\CustomerRating', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\OrderProduct model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function orderProducts() {
		return $this->hasMany('App\Models\OrderProduct', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ProductDiscount model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function productDiscounts() {
		return $this->hasMany('App\Models\ProductDiscount', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ProductModel model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function productModels() {
		return $this->hasMany('App\Models\ProductModel', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ProductSize model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function productSizes() {
		return $this->hasMany('App\Models\ProductSize', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ProductTranslation model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function productTranslations() {
		return $this->hasMany('App\Models\ProductTranslation', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ProductsColor model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function productsColors() {
		return $this->hasMany('App\Models\ProductsColor', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\ProductsDesign model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function productsDesigns() {
		return $this->hasMany('App\Models\ProductsDesign', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\SuppliersProduct model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function suppliersProducts() {
		return $this->hasMany('App\Models\SuppliersProduct', 'products_id', 'id');
	}

}
