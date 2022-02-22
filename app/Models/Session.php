<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model {
	/**
	 * The table associated with the model Session
	 *
	 * @var string
	 */
	protected $table = 'session_car';

	/**
	 *  The attributes that are mass assignable.
	 *
	 * @var bool
	 */
	protected $fillable = ['token', 'products_id', 'colors_id', 'sizes_id', 'qty'];
	/**
	 *  Indicates if the model should be timestamped.
	 *
	 * @var        boolean
	 */
	public $timestamps = false;

	/**
	 * Relationship with the App\Models\Color model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function colors() {
		return $this->belongsTo('App\Models\Color', 'colors_id', 'id');
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
