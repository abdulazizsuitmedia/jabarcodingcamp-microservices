<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::limit(10)->paginate();

        return response()->json([
            'status' => 200,
            'message' => 'Get Product Success',
            'result' => $products,
        ]);
    }
}
