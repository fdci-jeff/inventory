<?php

namespace App\Http\Livewire\Barcode;

use Livewire\Component;
use App\Models\Product;
use Milon\Barcode\Facades\DNS1DFacade;
use PDF;

class ProductTable extends Component
{
    public $product;
    public $quantity;
    public $barcodes;

    protected $listeners = ['productSelected'];

    public function mount()
    {
        $this->product = '';
        $this->quantity = 0;
        $this->barcodes = [];
    }

    public function render()
    {
        return view('livewire.barcode.product-table');
    }

    public function productSelected(Product $product)
    {
        $this->product = $product;
        $this->quatity = 1;
        $this->barcodes = [];
    }

    public function generateBarcodes(Product $product, $quantity)
    {
        if ($quantity > 100) {
            return session()->flash('error', 'You can only generate 100 barcodes at a time.');
        }

        $this->barcodes = [];

        for ($i = 0; $i < $this->quantity; $i++) {
            $barcode = DNS1DFacade::getBarcodeSVG($product->product_code, $product->product_barcode_symbology, 2, 60, '#000000', false);
            array_push($this->barcodes, $barcode);
        }
    }

    public function getPDF() 
    {
        
        $pdf = PDF::loadView('barcode.pdf', [
            'barcodes' => $this->barcodes,
            'price' => $this->product->product_price,
            'name' => $this->product->product_name,
        ]);
        
        $filename = 'barcodes-' . $this->product->product_code . '.pdf';

        return $pdf->stream($filename);
    }

    public function updatedQuantity()
    {
        $this->barcodes = [];
    }
}
