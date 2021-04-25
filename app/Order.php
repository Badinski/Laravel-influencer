<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAttribute()
    {
        return $this->orderItems->sum(function (OrderItem $item) {
            return $item->price * $item->quantity;
        });
    }

    /*An accessor transforms an Eloquent attribute value when it is accessed.
     To define an accessor, create a get{Attribute}Attribute method on your model where 
    {Attribute} is the "studly" cased name of the column you wish to access. */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
