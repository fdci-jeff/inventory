<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category;

class ProductController extends Controller
{
    public function create()
    {
        abort_if(Gate::denies('create_products'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all();

        // set compact data for category
        return view('product.create', compact('categories'));
    }
}
