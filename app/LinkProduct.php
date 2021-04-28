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
 */
class LinkProduct extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;
}
