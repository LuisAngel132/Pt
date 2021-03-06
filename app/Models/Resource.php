<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the resources table
 *
 * automatically generated by ModelGenerator.php
 */
class Resource extends Model {

	/**
	 * The table associated with the model Resource
	 *
	 * @var string
	 */
	protected $table = 'resources';

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
	protected $fillable = ['name', 'is_active'];

	/**
	 * Relationship with the App\Models\ProductsColor model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function productsColors() {
		return $this->belongsTo('App\Models\ProductsColor', 'products_colors_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Galleries model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function galleries() {
		return $this->hasMany('App\Models\Galleries', 'resources_id', 'id');
	}

}
