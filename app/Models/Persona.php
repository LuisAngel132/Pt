<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
      protected $table = 'people';
	public $timestamps = false;
	protected $fillable = [
		'full_name',
	 	'name',
	 	'last_name',
	 	'gender'
	];

	public function userPeople()
	{
		return $this->hasOne('App\User', 'people_id');
	}
}
