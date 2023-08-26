<?php

namespace App\Http\Controllers\Adjustment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Adjustment\AdjustmentRequest;
use App\Http\DataTables\AdjustmentDataTables;
use App\Models\AdjustedProduct;
use App\Models\Adjustment;
use App\Models\Product;
use DB;

class AdjustmentController extends Controller
{
    public function create()
    {
        abort_if(Gate::denies('create_adjustments'), 403);

        return view('adjustments.create');
    }

    public function store(AdjustmentRequest $request){
        abort_if(Gate::denies('create_adjustments'), 403);

        DB::transaction(function () use ($request) {
            $adjustment = Adjustment::create([
                'date' => $request->date,
                'note' => $request->note,
                'reference' => $request->reference
            ]);

            foreach ($request->product_ids as $key => $id) {
                AdjustedProduct::create([
                    'adjustment_id' => $adjustment->id,
                    'product_id' => $id,
                    'quantity' => $request->quantities[$key],
                    'type' => $request->types[$key]
                ]);

                $product = Product::find($id);

                if ($request->types[$key] == 'add') {
                    $product->update([
                        'product_quantity' => $product->quantity + $request->quantities[$key]
                    ]);
                } elseif ($request->types[$key] == 'sub') {
                    $product->update([
                        'product_quantity' => $product->quantity - $request->quantities[$key]
                    ]);
                }
            }
        });

        toast('Adjustment Created!', 'success');

        return redirect()->route('adjustments.index');
    }

    public function index(AdjustmentDatatables $datatable){
        abort_if(Gate::denies('access_adjustments'), 403);

        return $datatable->render('adjustments.index');
    }
}
