<?php

namespace App\Http\Controllers\Admin;
use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;

class OrderController
{
    public function index()
    {

        $order = Order::paginate();

        return OrderResource::collection($order);
    }

    public function show($id)
    {

        return new OrderResource(Order::find($id));
    }

    public function export()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=orders.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () {
            $orders = Order::all();
            $file = fopen('php://output', 'w');

            //Header Row
            fputcsv($file, ['ID', 'Name', 'Email', 'Order Title', 'Price', 'Quantity']);

            //Body
            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);

                foreach ($order->orderItems as $orderItem) {
                    fputcsv($file, ['', '', '', $orderItem->product_title, $orderItem->price, $orderItem->quantity]);
                }
            }

            fclose($file);
        };



        /*HTTP Streaming is a push-style data transfer technique that allows a web server
         to continuously send data to a client over a single HTTP connection that remains 
         open indefinitely. Technically, this goes against HTTP convention, but HTTP Streaming 
         is an efficient method to transfer all kinds of 
        or otherwise streamable data between the server and client without reinventing HTTP.*/
        return \Response::stream($callback, 200, $headers);
    }
}
