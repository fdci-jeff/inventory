<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\DataTables\ProductDataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        abort_if(Gate::denies('create_products'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all();

        // set compact data for category
        return view('product.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->except('document'));

        if (isset($request->document) && count($request->document) > 0) {
            foreach ($request->document as $file) {
                $product->addMedia(Storage::disk('public')->path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        toast('Product Created!', 'success');

        return redirect()->route('products.index');
    }

    public function index(ProductDataTables $dataTable) {
        abort_if(Gate::denies('access_products'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $dataTable->render('product.index');
    }

    public function show(Product $product) {
        abort_if(Gate::denies('show_products'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('product.show', compact('product'));
    }
}
