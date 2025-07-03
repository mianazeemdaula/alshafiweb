<?php

namespace App\Livewire\Cart;

use Livewire\Component;

class CartPage extends Component
{

    public function render()
    {
        return view('livewire.cart.cart');
    }

    #[On('cart-page-updated')]
    public function updateCart(){
        $this->dispatch('refresh-cart-count')->to('cart-counter');
    }
}
