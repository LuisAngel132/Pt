<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the product_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class ProductTranslation extends Model {
	/**
	 * The table associated with the model ProductTranslation
	 *
	 * @var string
	 */
	protected $table = 'product_translations';

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
	protected $fillable = ['name', 'description', 'price'];

	/**
	 * Relationship with the App\Models\Lang model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function langs() {
		return $this->belongsTo('App\Models\Lang', 'langs_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Product model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function products() {
		return $this->belongsTo('App\Models\Product', 'products_id', 'id');
	}

}
