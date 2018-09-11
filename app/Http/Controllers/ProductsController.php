<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\DB;
use App\CategoryProduct;

class ProductsController extends Controller
{
    public function index(Category $category)
    {
        $data = [
            'products' => $category->products()->paginate(10),
            'selectedCategory' => $category,
        ];

        return request()->wantsJson()
            ? response()->json($data)
            : view('products.index', $data);
    }

    public function search($query)
    {
        $products = Product::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(10);

        $data = [
            'products' => $products,
            'searchQuery' => $query,
        ];

        return request()->wantsJson()
            ? response()->json($data)
            : view('products.index', $data);
    }
}
