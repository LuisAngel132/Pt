<?php
namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent class to describe the colors_resources table
 *
 * automatically generated by ModelGenerator.php
 */
class ColorsResource extends Model
{
    /**
     * The table associated with the model ColorsResource
     *
     * @var string
     */
    protected $table = 'colors_resources';

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
    protected $fillable = [];

    /**
     * Relationship with the App\Models\ProductsColor model.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function productsColors()
    {
        return $this->belongsTo('App\Models\Product\ProductsColor', 'products_colors_id', 'id');
    }

    /**
     * Relationship with the App\Models\Resource model.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function resources()
    {
        return $this->belongsTo('App\Models\Product\Resource', 'resources_id', 'id');
    }

}
