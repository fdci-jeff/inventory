<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\DataTables\CategoryDataTables;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(CategoryDataTables $dataTable) {
        abort_if(Gate::denies('access_product_categories'), 403);

        return $dataTable->render('category.index');
    }

    public function store(CategoryRequest $request) {
        abort_if(Gate::denies('access_product_categories'), 403);

        DB::beginTransaction();
        try {
            Category::create([
                'category_code' => $request->category_code,
                'category_name' => $request->category_name,
            ]);
            DB::commit();
            
            toast('Product Category Created!', 'success');
            
            return redirect()->back();
            
        } catch (Exception $e) {
            DB::rollback();
            Log::error(get_class().':store(): '.$e->getMessage());

            return false;
        }
    }
}
