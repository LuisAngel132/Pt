<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    /**
 * The table associated with the model Fees
 *
 * @var string
 */
    protected $table = 'fees';

 /**
  * Indicates if the model should be timestamped.
  *
  * @var bool
  */
 public $timestamps = true;

 /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['base_price', 'is_active'];


    /**
    * Relationship with the App\Models\FeeTranslations model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\hasMany
    */ 
    public function feeTranslations()
    {
        return $this->hasMany('App\Models\FeeTranslations', 'fees_id', 'id'); //Relación que tiene con la tabla fee_translations
    }
}
