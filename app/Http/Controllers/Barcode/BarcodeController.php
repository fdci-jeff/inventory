<?php

namespace App\Http\Controllers\Barcode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class BarcodeController extends Controller
{
    public function print()
    {
        abort_if(Gate::denies('print_barcodes'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('barcode.print');
    }

    public function pdf()
    {
        abort_if(Gate::denies('print_barcodes'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('barcode.print');
    }
}
