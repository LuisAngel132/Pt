<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the fee_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class FeeTranslation extends Model
{
 /**
 * The table associated with the model FeeTranslation
 *
 * @var string
 */
    protected $table = 'fee_translations';

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
    * Relationship with the App\Models\Fee model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function fees()
    {
        return $this->belongsTo('App\Models\Fee', 'fees_id', 'id');
    }

    /**
    * Relationship with the App\Models\Lang model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function langs()
    {
        return $this->belongsTo('App\Models\Lang', 'langs_id', 'id');
    }

}
