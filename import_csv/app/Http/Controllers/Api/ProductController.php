<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $mpn = $request->get('mpn');

        
        if (empty($mpn)) {
            $products_count = Product::count();
            $products = Product::offset($offset)->limit($limit)->get();
        } else {
            $products_count = Product::where('mpn', $mpn)->count();
            $products = Product::where('mpn', $mpn)->offset($offset)->limit($limit)->get();
        }

        return [
            'products' => $products,
            'products_count' => $products_count
        ];
    }
}
