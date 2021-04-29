<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LinkProduct
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProduct query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $link_id
 * @property int $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProduct whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProduct whereProductId($value)
 */
class LinkProduct extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;
}
