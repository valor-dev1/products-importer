<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.product.show-products',[
            'products' => Product::paginate(5)
        ]);
    }
}
