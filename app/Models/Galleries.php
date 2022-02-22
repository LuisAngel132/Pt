<?php

namespace App\Models;

use App\Traits\S3Trait;
use Illuminate\Database\Eloquent\Model;

class Galleries extends Model {
	use S3Trait;
	/**
	 * The table associated with the model Resource
	 *
	 * @var string
	 */
	protected $table = 'galleries';

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
	protected $fillable = ['image_url'];

	protected $appends = [
		'public_image_url',
	];
	public function getPublicImageUrlAttribute() {
		return $this->temporaryUrl($this->attributes['image_url']);
	}

	/**
	 * Relationship with the App\Models\Resource model.
	 *
	 * @return    Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function resources() {
		return $this->belongsTo('App\Models\Resource', 'resources_id', 'id');
	}
}
