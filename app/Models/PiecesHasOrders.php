<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiecesHasOrders extends Model
{
    protected $table = 'pieces_has_orders';
    public $timestamps = false;

    protected $fillable = [];

    public function orders_id()
    {
        return $this->belongsTo('App\Models\Order', 'orders_id', 'id');
    }

    public function piecesOrder()
    {
        return $this->belongsTo('App\Models\Pieces', 'pieces_id', 'id');
    }

}
