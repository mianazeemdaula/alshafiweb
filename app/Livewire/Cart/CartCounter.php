<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    public $cartCount = 5;

    // protected $listeners = [
    //     'refresh-cart-count' => '$refresh',
    // ];

    public function render()
    {
        return view('livewire.cart.cart-counter');
    }

    #[On('refresh-cart-count')]
    public function refreshCartCount()
    {
        $this->cartCount = $this->cartCount + 1;
    }
    
}
