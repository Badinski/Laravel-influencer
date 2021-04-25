<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /*While ID is not fillable by default, 
    it can be still overwritten when modified directly with $model->id = $id; */
    protected $guarded = ['id'];
}
