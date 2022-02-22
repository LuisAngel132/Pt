<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StyleResources extends Model
{
    protected $table = 'style_resources';
    public $timestamps = false;
    protected $fillable = ['image_url'];

    public function product_styles_id()
    {
        return $this->belongsTo('App\Models\ProductStyle', 'product_styles_id', 'id');
    }
}
