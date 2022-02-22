<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeTranslations extends Model
{
    /**
    * The table associated with the model FeeTranslations
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
    * Relationship with the App\Models\Fees model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function fees()
    {
        return $this->belongsTo('App\Models\Fees', 'fees_id', 'id'); //Relación inversa con la tabla fees
    }

    /**
    * Relationship with the App\Models\Lang model.
    * 
    * @return    Illuminate\Database\Eloquent\Relations\belongsTo
    */ 
    public function langs()
    {
        return $this->belongsTo('App\Models\Lang', 'langs_id', 'id'); //Relación que tiene con la tabla langs
    }
}
