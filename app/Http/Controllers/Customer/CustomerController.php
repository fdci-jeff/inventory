<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create() {
        abort_if(Gate::denies('create_customers'), 403);

        return view('customers.create');
    }

    public function store(Request $request) {
        
    }
}
