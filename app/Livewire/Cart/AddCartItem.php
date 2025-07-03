<?php

namespace App\Livewire\Cart;

use Livewire\Component;

class AddCartItem extends Component
{
    public function render()
    {
        return view('livewire.cart.add-cart-item');
    }

    public function addCartItem($product_id){
        $this->dispatch('refresh-cart-count');
    }
}
