<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the codes_discount_types table
 *
 * automatically generated by ModelGenerator.php
 */
class CodesDiscountType extends Model {
	/**
	 * The table associated with the model CodesDiscountType
	 *
	 * @var string
	 */
	protected $table = 'codes_discount_types';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['available_redeems', 'codes_id', 'discount_types_id'];

	/**
	 * Relationship with the App\Models\Code model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function codes() {
		return $this->belongsTo('App\Models\Code', 'codes_id', 'id');
	}

	/**
	 * Relationship with the App\Models\DiscountType model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function discountTypes() {
		return $this->belongsTo('App\Models\DiscountType', 'discount_types_id', 'id');
	}

}
