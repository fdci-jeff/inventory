<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use Exception;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\DataTables\CustomerDataTables;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create() {
        abort_if(Gate::denies('create_customers'), 403);

        return view('customers.create');
    }

    public function store(CustomerRequest $request) {
        abort_if(Gate::denies('create_customers'), 403);

        DB::beginTransaction();
        try {
            Customer::create([
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'city'           => $request->city,
                'country'        => $request->country,
                'address'        => $request->address
            ]);
            DB::commit();
            
            toast('Customer Created!', 'success');
            
            return redirect()->route('customer.index');
            
        } catch (Exception $e) {
            DB::rollback();
            Log::error(get_class().':store(): '.$e->getMessage());

            return false;
        }
    }

    public function index(CustomerDataTables $dataTable) {
        abort_if(Gate::denies('access_customers'), 403);

        return $dataTable->render('customers.index');
    }
}
