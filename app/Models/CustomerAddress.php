<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the customer_addresses table
 *
 * automatically generated by ModelGenerator.php
 */
class CustomerAddress extends Model {
	/**
	 * The table associated with the model CustomerAddress
	 *
	 * @var string
	 */
	protected $table = 'customer_addresses';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['address_types_id', 'addresses_id', 'customers_id', 'payment_shipping_contact_id', 'is_default', 'is_active'];

	/**
	 * Relationship with the App\Models\AddressType model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function addressTypes() {
		return $this->belongsTo('App\Models\AddressType', 'address_types_id', 'id');
	}

	/**
	 * Relationship with the App\Models\Address model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function addresses() {
		return $this->belongsTo('App\Models\Address', 'addresses_id', 'id');
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
	 * Relationship with the App\Models\Shipment model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function shipments() {
		return $this->hasMany('App\Models\Shipment', 'customer_addresses_id', 'id');
	}

}
