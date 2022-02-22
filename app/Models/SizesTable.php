<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizesTable extends Model
{
    protected $table = 'sizes_table';
    public $timestamps = true;
    protected $fillable = ['guide_image','is_active'];

    public function productGenres()
    {
        return $this->belongsTo('App\Models\ProductGenre', 'product_genres_id', 'id');
    }
    public function productStyles()
    {
        return $this->belongsTo('App\Models\ProductStyle', 'product_styles_id', 'id');
    }
    public function productTypes()
    {
        return $this->belongsTo('App\Models\ProductType', 'product_types_id', 'id');
    }

    public function sizeTableHasSize()
    {
        return $this->hasMany('App\Models\SizesTableHasSizes', 'sizes_table_id', 'id');
    }


}
