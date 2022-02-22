<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizesTableHasSizes extends Model
{
    protected $table = 'sizes_table_has_sizes';
    public $timestamps = false;
    protected $fillable = ['shirt_length_in', 'shirt_length_cm', 'chest_width_in', 'chest_width_cm', 'sleeve_length_in', 'sleeve_length_cm'];

    public function sizesTable()
    {
        return $this->belongsTo('App\Models\SizesTable', 'sizes_table_id', 'id');
    }

    public function sizes()
    {
        return $this->belongsTo('App\Models\Size', 'sizes_id', 'id');
    }
}
