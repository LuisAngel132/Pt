<?php 
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Eloquent class to describe the models table
 *
 * automatically generated by ModelGenerator.php
 */
class PromotionCode extends Model
{
    protected $table="codes";
    protected $fillable = ['promotion_types_id', 'discount_types_id', 'code','is_active','start_date','end_date', 'amount'];

    public function tipo(){
    	return $this->belongsTo('App\Models\PromotionType', 'promotion_types_id', 'id');
    }

    public function tdescuento(){
    	return $this->belongsTo('App\Model\DiscountTypes', 'discount_types_id', 'id');
    }
}
