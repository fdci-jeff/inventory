<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Category;

class PosController extends Controller
{
    public function index() {
        Cart::instance('sale')->destroy();

        $customers = Customer::all();
        $product_categories = Category::all();

        return view('sale.pos.index', compact('product_categories', 'customers'));
    }
}
