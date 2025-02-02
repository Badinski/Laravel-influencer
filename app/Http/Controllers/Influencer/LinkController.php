<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Link;
use App\LinkProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function store(Request $request)
    {
        $link = Link::create([
            'user_id' => $request->user()->id,
            'code' => Str::random(6),
        ]);

        $products = $request->input('products');
        
            foreach($products as $product_id)
            {
                LinkProduct::create([
                'link_id' => $link->id,
                'product_id' => $product_id,
                ]);
            }
        

        return new LinkResource($link);
    }
}
