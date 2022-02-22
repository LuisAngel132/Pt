<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the address_type_translations table
 *
 * automatically generated by ModelGenerator.php
 */
class AddressTypeTranslation extends Model
{
 /**
 * The table associated with the model AddressTypeTranslation
 *
 * @var string
 */
    protected $table = 'address_type_translations';

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
    protected $fillable = ['type', 'description'];

    /**
    * Relationship with the App\Models\AddressType model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function addressTypes()
    {
        return $this->belongsTo('App\Models\AddressType', 'address_types_id', 'id');
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
