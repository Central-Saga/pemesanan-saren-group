<?php

namespace App\Livewire\Frontend;

use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class OrderSuccess extends OrderTracker
{
    public function render()
    {
        return view('livewire.frontend.order-success');
    }
}
