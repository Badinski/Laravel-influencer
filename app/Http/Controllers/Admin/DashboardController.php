<?php

namespace App\Http\Controllers\Admin;
use App\Http\Resources\ChartResource;
use App\Order;
use Illuminate\Http\Request;

class DashboardController
{
    public function chart()
    {
        /*Gates are simply closures that determine if a user is authorized to perform a given action. 
        Typically, gates are defined within the boot method of the
         App\Providers\AuthServiceProvider class using the Gate facade.  */
        \Gate::authorize('view', 'orders');
        
        $orders = Order::query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, sum(order_items.quantity*order_items.price) as sum")
            ->groupBy('date')
            ->get();

        return ChartResource::collection($orders);
    }
}
