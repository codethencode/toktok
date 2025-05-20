<?php

namespace App\View\Components;

use App\Models\Basket;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OrderSummary extends Component
{
    /**
     * Create a new component instance.
     */
    public $orderId;
    public $basket;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
        $this->basket = Basket::where('order_id', $orderId)->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.order-summary');
    }
}
