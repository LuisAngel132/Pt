<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pieces extends Model
{
    protected $table = 'pieces';
    public $timestamps = false;

    protected $fillable = ['weight', 'width', 'height', 'depth'];

    public function pieces_has_orders()
    {
        return $this->hasMany('App\Models\PiecesHasOrders', 'pieces_id', 'id');
    }
}
