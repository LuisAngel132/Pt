<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the carts table
 *
 * automatically generated by ModelGenerator.php
 */
class Cart extends Model {
	/**
	 * The table associated with the model Cart
	 *
	 * @var string
	 */
	protected $table = 'carts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['qty', 'customers_id', 'products_id', 'sizes_id', 'colors_id'];

	/**
	 * Relationship with the App\Models\Color model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function colors() {
		return $this->belongsTo('App\Models\Color', 'colors_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Customer model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function customers() {
		return $this->belongsTo('App\Models\Customer', 'customers_id', 'id');
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
	 * Relationship with the App\Models\Size model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function sizes() {
		return $this->belongsTo('App\Models\Size', 'sizes_id', 'id');
	}

}
