<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the products_colors table
 *
 * automatically generated by ModelGenerator.php
 */
class ProductsColor extends Model {
	/**
	 * The table associated with the model ProductsColor
	 *
	 * @var string
	 */
	protected $table = 'products_colors';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['stock_quantity'];

	/**
	 * Relationship with the App\Models\Color model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function colors() {
		return $this->belongsTo('App\Models\Color', 'colors_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Size model.
	 *
	 * @return     Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function size() {
		return $this->belongsTo('App\Models\Size', 'sizes_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Product model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function products() {
		return $this->belongsTo('App\Models\Product', 'products_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Movement model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function movements() {
		return $this->hasMany('App\Models\Movement', 'products_colors_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Resource model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function resources() {
		return $this->belongsTo('App\Models\Resource', 'resources_id', 'id');
	}

}